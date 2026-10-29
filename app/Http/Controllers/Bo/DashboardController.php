<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kolom = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'data_umum_2026')
            ->whereNull('deleted_at')
            ->orderBy('urutan')
            ->get();

        $kecamatan = DB::table('m_kecamatan')
            ->whereNull('deleted_at')
            ->orderBy('nama_kec')
            ->get();

        $sumCols = $kolom->pluck('alias')
            ->map(fn ($a) => "SUM($a) AS $a")
            ->implode(', ');

        $data = DB::table('data_umum_2026')
            ->selectRaw("id_kec, $sumCols")
            ->where('periode', 2026)
            ->groupBy('id_kec')
            ->get()
            ->keyBy('id_kec');

        $kolomPokja1 = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_1_2026')
            ->whereNull('deleted_at')
            ->orderBy('urutan')
            ->get();

        $dataPokja1 = DB::table('d_pokja_1_2026')
            ->where('periode', 2026)
            ->whereNull('id_kel')
            ->get()
            ->keyBy('id_kec');

        $kolomPokja2 = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_2_2026')
            ->whereNull('deleted_at')
            ->orderBy('urutan')
            ->get();

        $dataPokja2 = DB::table('d_pokja_2_2026')
            ->where('periode', 2026)
            ->get()
            ->keyBy('id_kec');

        return view('bo.pages.dashboard', [
            'level'       => 'kecamatan',
            'baris'       => $kecamatan,
            'kecamatan'   => $kecamatan,
            'kolom'       => $kolom,
            'data'        => $data,
            'kolomPokja1' => $kolomPokja1,
            'dataPokja1'  => $dataPokja1,
            'kolomPokja2' => $kolomPokja2,
            'dataPokja2'  => $dataPokja2,
        ]);
    }
}