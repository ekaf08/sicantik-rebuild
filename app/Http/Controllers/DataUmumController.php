<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataUmumController extends Controller
{
    public function kelurahan($idKec)
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

        return view('bo.pages.dashboard', [
            'activeTab' => request()->query('tab', 'data_umum'),
            'level'       => 'kelurahan',
            'kec'         => $kec,
            'baris'       => $baris,
            'kecamatan'   => collect(),
            'kolom'       => $kolom,
            'data'        => $data,   // UBAH: sebelumnya collect()
            'kolomPokja1' => collect(),
            'dataPokja1'  => collect(),
            'kolomPokja2' => collect(),
            'dataPokja2'  => collect(),
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