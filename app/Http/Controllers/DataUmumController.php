<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataUmumController extends Controller
{
    public function kelurahan($idKec, $activeTab = 'data_umum')
    {
        $kec = DB::table('m_kecamatan')->where('id_kec', $idKec)->first();
        abort_if(!$kec, 404);

        $kolom = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'data_umum_2026')
            ->whereNull('deleted_at')->orderBy('urutan')->get();

        $baris = DB::table('m_kelurahan')
            ->where('kode_kec_bpjs', $kec->kode_bpjs)
            ->orderBy('nama_kel')->get();

        // BARU: angka per kelurahan, dicocokkan lewat id_kel
        $data = DB::table('data_umum_2026')
            ->where('id_kec', $idKec)
            ->where('periode', 2026)
            ->whereNotNull('id_kel')
            ->get()
            ->keyBy('id_kel');

        // Tiap kelurahan = 1
        foreach ($baris as $kel) {
            if ($data->has($kel->id_kel)) {
                $data[$kel->id_kel]->kelurahan = 1;
            } else {
                $data[$kel->id_kel] = (object) ['id_kel' => $kel->id_kel, 'kelurahan' => 1];
            }
        }

        // Dasa Wisma per kelurahan, dihitung dari tabel detail
        $jmlDasaWisma = DB::table('d_dasa_wisma_2026')
            ->where('id_kec', $idKec)
            ->where('periode', 2026)
            ->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')
            ->pluck('total', 'id_kel');

        foreach ($baris as $kel) {
            $jml = $jmlDasaWisma[$kel->id_kel] ?? 0;

            if ($data->has($kel->id_kel)) {
                $data[$kel->id_kel]->dasa_wisma = $jml;
            } else {
                $data[$kel->id_kel] = (object) ['id_kel' => $kel->id_kel, 'dasa_wisma' => $jml];
            }
        }

        $kader = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kel, jenis_kader, jenis_kelamin, COUNT(*) AS total')
            ->groupBy('id_kel', 'jenis_kader', 'jenis_kelamin')
            ->get();

        foreach ($kader as $r) {
            $alias = $r->jenis_kader . '_' . strtolower($r->jenis_kelamin);
            if (!$data->has($r->id_kel)) {
                $data[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $data[$r->id_kel]->$alias = $r->total;
        }

        $pend = DB::table('d_penduduk_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw("id_kel,
                COUNT(*) FILTER (WHERE kepala_keluarga) AS kk,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'L') AS jumlah_jiwa_l,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'P') AS jumlah_jiwa_p")
            ->groupBy('id_kel')
            ->get();

        foreach ($pend as $r) {
            if (!$data->has($r->id_kel)) {
                $data[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $data[$r->id_kel]->kk = $r->kk;
            $data[$r->id_kel]->jumlah_jiwa_l = $r->jumlah_jiwa_l;
            $data[$r->id_kel]->jumlah_jiwa_p = $r->jumlah_jiwa_p;
        }

        $rw = DB::table('d_lembaga_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)
            ->where('jenis', 'rw')->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')->pluck('total', 'id_kel');

        foreach ($rw as $idKel => $total) {
            if (!$data->has($idKel)) {
                $data[$idKel] = (object) ['id_kel' => $idKel];
            }
            $data[$idKel]->rw = $total;
        }

        // Pokja 2 level kelurahan: angka dari d_kader_2026
        $dataPokja2 = collect();

        $mapPokja2 = [
            'warga_3_buta' => 'warga_buta',   'tpk3_pkk' => 'tpk3_pkk',
            'damas_pkk' => 'damas_pkk',       'pemula_psrt' => 'up2k_pemula',
            'madya_psrt' => 'up2k_madya',     'anggota' => 'koperasi_anggota',
            'tutor_kf' => 'tutor_kf',         'kader_koperasi' => 'kader_koperasi',
            'kader_keterampilan' => 'kader_keterampilan',
            'kader_bkb' => 'kader_bkb',       'lp3_pkk' => 'lp3_pkk',
        ];

        $cacah = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->whereIn('jenis_kader', array_values($mapPokja2))
            ->selectRaw('id_kel, jenis_kader, COUNT(*) AS total')
            ->groupBy('id_kel', 'jenis_kader')->get();

        $aliasDariJenis = array_flip($mapPokja2);
        foreach ($cacah as $r) {
            if (!$dataPokja2->has($r->id_kel)) {
                $dataPokja2[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $dataPokja2[$r->id_kel]->{$aliasDariJenis[$r->jenis_kader]} = $r->total;
        }

        return view('bo.pages.dashboard', [
            'activeTab' => request()->query('tab', $activeTab),
            'level'       => 'kelurahan',
            'kec'         => $kec,
            'baris'       => $baris,
            'kecamatan'   => collect(),
            'kolom'       => $kolom,
            'data'        => $data,   // UBAH: sebelumnya collect()
            'kolomPokja1' => collect(),
            'dataPokja1'  => collect(),
            'kolomPokja2' => $this->kolom('d_pokja_2_2026'),
            'dataPokja2'  => $dataPokja2,
            'kolomPokja3' => $this->kolom('d_pokja_3_2026'),
            'dataPokja3'  => $this->dataKelurahan('d_pokja_3_2026', $idKec),
            'kolomPokja4' => $this->kolom('d_pokja_4_2026'),
            'dataPokja4'  => $this->dataKelurahan('d_pokja_4_2026', $idKec),
        ]);
    }


    private function dataKelurahan(string $tabel, $idKec)
    {
        return DB::table($tabel)
            ->where('id_kec', $idKec)
            ->where('periode', 2026)
            ->whereNotNull('id_kel')
            ->get()
            ->keyBy('id_kel');
    }

    private function kolom(string $tbDashboard)
    {
        return DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', $tbDashboard)
            ->whereNull('deleted_at')
            ->orderBy('urutan')->get();
    }
}