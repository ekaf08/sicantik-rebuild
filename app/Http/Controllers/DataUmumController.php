<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bo\Pokja3Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Support\Pokja1;
use App\Http\Controllers\Bo\Pokja4Controller;

class DataUmumController extends Controller
{
    public function kelurahan($idKec, $activeTab = 'data_umum')
    {
        $kec = DB::table('m_kecamatan')->where('id_kec', $idKec)->first();
        abort_if(!$kec, 404);

        $kolom = $this->kolom('data_umum_2026');

        $baris = DB::table('m_kelurahan')
            ->where('kode_kec_bpjs', $kec->kode_bpjs)
            ->orderBy('nama_kel')->get();

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

        // Dasa Wisma
        $jmlDasaWisma = DB::table('d_dasa_wisma_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')->pluck('total', 'id_kel');

        foreach ($baris as $kel) {
            $jml = $jmlDasaWisma[$kel->id_kel] ?? 0;
            if ($data->has($kel->id_kel)) {
                $data[$kel->id_kel]->dasa_wisma = $jml;
            } else {
                $data[$kel->id_kel] = (object) ['id_kel' => $kel->id_kel, 'dasa_wisma' => $jml];
            }
        }

        // Kader
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

        // Penduduk
        $pend = DB::table('d_penduduk_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw("id_kel,
                COUNT(*) FILTER (WHERE kepala_keluarga) AS kk,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'L') AS jumlah_jiwa_l,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'P') AS jumlah_jiwa_p")
            ->groupBy('id_kel')->get();

        foreach ($pend as $r) {
            if (!$data->has($r->id_kel)) {
                $data[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $data[$r->id_kel]->kk = $r->kk;
            $data[$r->id_kel]->jumlah_jiwa_l = $r->jumlah_jiwa_l;
            $data[$r->id_kel]->jumlah_jiwa_p = $r->jumlah_jiwa_p;
        }

        // RW
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

        // ===== Pokja 2 =====
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

        $bkb = DB::table('d_bkb_kelompok_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS kelp, COALESCE(SUM(jumlah_ape),0) AS ape,
                        COUNT(*) FILTER (WHERE is_simulasi) AS simulasi')
            ->groupBy('id_kel')->get();

        foreach ($bkb as $r) {
            if (!$dataPokja2->has($r->id_kel)) {
                $dataPokja2[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $dataPokja2[$r->id_kel]->bkb_kelp = $r->kelp;
            $dataPokja2[$r->id_kel]->bkb_ape = $r->ape;
            $dataPokja2[$r->id_kel]->bkb_kelp_simulasi = $r->simulasi;
        }

        $ibu = DB::table('d_bkb_ibu_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')->pluck('total', 'id_kel');

        foreach ($ibu as $idKel => $total) {
            if (!$dataPokja2->has($idKel)) {
                $dataPokja2[$idKel] = (object) ['id_kel' => $idKel];
            }
            $dataPokja2[$idKel]->bkb_ibu_peserta = $total;
        }

        $kl = DB::table('d_kelompok_belajar_2026 as d')
            ->join('m_pertanyaan_dashboard_2026 as p', 'p.id', '=', 'd.id_pertanyaan')
            ->where('d.id_kec', $idKec)->where('d.periode', 2026)->whereNull('d.deleted_at')
            ->selectRaw('d.id_kel, p.alias, COUNT(*) AS total')
            ->groupBy('d.id_kel', 'p.alias')->get();

        foreach ($kl as $r) {
            if (!$dataPokja2->has($r->id_kel)) {
                $dataPokja2[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $dataPokja2[$r->id_kel]->{$r->alias} = $r->total;
        }

        $wb = DB::table('d_warga_belajar_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kel, jenis_paket, COUNT(*) AS total')
            ->groupBy('id_kel', 'jenis_paket')->get();

        foreach ($wb as $r) {
            $p = strtolower($r->jenis_paket);
            $alias = $p === 'kf' ? 'kf_warga' : "paket_{$p}_warga";
            if (!$dataPokja2->has($r->id_kel)) {
                $dataPokja2[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $dataPokja2[$r->id_kel]->$alias = $r->total;
        }

        $pd = DB::table('d_paud_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(DISTINCT npsn) AS lembaga,
                         COUNT(*) FILTER (WHERE nama_pegawai IS NOT NULL) AS tutor')
            ->groupBy('id_kel')->get();

        foreach ($pd as $r) {
            if (!$dataPokja2->has($r->id_kel)) {
                $dataPokja2[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $dataPokja2[$r->id_kel]->paud_sejenis = $r->lembaga;
            $dataPokja2[$r->id_kel]->tutor_paud_sejenis = $r->tutor;
        }

        $tb = DB::table('d_taman_bacaan_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')->pluck('total', 'id_kel');

        foreach ($tb as $idKel => $total) {
            if (!$dataPokja2->has($idKel)) {
                $dataPokja2[$idKel] = (object) ['id_kel' => $idKel];
            }
            $dataPokja2[$idKel]->taman_bacaan = $total;
        }

        // ===== Pokja 3 (punya Pokja3Controller) =====
        $pokja3 = Pokja3Controller::getRekapData(2026, (int) $idKec);

        return view('bo.pages.dashboard', [
            'activeTab'   => request()->query('tab', $activeTab),
            'level'       => 'kelurahan',
            'kec'         => $kec,
            'baris'       => $baris,
            'kecamatan'   => collect(),
            'kolom'       => $kolom,
            'data'        => $data,
            'kolomPokja1' => $this->kolom('d_pokja_1_2026'),
            'dataPokja1'  => Pokja1::perKelurahan($idKec),
            'kolomPokja2' => $this->kolom('d_pokja_2_2026'),
            'dataPokja2'  => $dataPokja2,
            'kolomPokja3' => $pokja3['kolomPokja3'],
            'dataPokja3'  => $pokja3['dataPokja3'],
            'kolomPokja4' => $this->kolom('d_pokja_4_2026'),
            'dataPokja4' => Pokja4Controller::getRekapData(2026, (int) $idKec),
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