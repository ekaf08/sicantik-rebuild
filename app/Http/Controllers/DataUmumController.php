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

        return view('bo.pages.dashboard', [
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