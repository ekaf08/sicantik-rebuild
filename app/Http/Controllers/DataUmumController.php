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

        return view('bo.pages.dashboard', [
            'level'       => 'kelurahan',
            'kec'         => $kec,
            'baris'       => $baris,
            'kecamatan'   => collect(),
            'kolom'       => $kolom,
            'data'        => collect(),
            'kolomPokja1' => collect(),
            'dataPokja1'  => collect(),
            'kolomPokja2' => collect(),
            'dataPokja2'  => collect(),
        ]);
    }
}