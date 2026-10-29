<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kecamatan = DB::table('m_kecamatan')
            ->whereNull('deleted_at')
            ->orderBy('nama_kec')
            ->get();

        // Data Umum: angka kecamatan = SUM baris kelurahan
        $kolom = $this->kolom('data_umum_2026');
        $data  = $this->sumPerKecamatan('data_umum_2026', $kolom);

        $kolomPokja1 = $this->kolom('d_pokja_1_2026');
        $dataPokja1  = DB::table('d_pokja_1_2026')
            ->where('periode', 2026)
            ->whereNull('id_kel')
            ->get()
            ->keyBy('id_kec');

        $kolomPokja2 = $this->kolom('d_pokja_2_2026');
        $dataPokja2  = DB::table('d_pokja_2_2026')
            ->where('periode', 2026)
            ->get()
            ->keyBy('id_kec');

        // Pokja 3 dan 4 
        $kolomPokja3 = $this->kolom('d_pokja_3_2026');
        $dataPokja3  = $this->sumPerKecamatan('d_pokja_3_2026', $kolomPokja3);

        $kolomPokja4 = $this->kolom('d_pokja_4_2026');
        $dataPokja4  = $this->sumPerKecamatan('d_pokja_4_2026', $kolomPokja4);

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
            'kolomPokja3' => $kolomPokja3,
            'dataPokja3'  => $dataPokja3,
            'kolomPokja4' => $kolomPokja4,
            'dataPokja4'  => $dataPokja4,
        ]);
    }

    private function kolom(string $tbDashboard)
    {
        return DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', $tbDashboard)
            ->whereNull('deleted_at')
            ->orderBy('urutan')
            ->get();
    }

    // Jumlahkan baris kelurahan per kecamatan
    private function sumPerKecamatan(string $tabel, $kolom)
    {
        if ($kolom->isEmpty()) {
            return collect();
        }

        $sum = $kolom->pluck('alias')
            ->map(fn ($a) => 'SUM("' . str_replace('"', '""', $a) . '") AS "' . str_replace('"', '""', $a) . '"')
            ->implode(', ');

        return DB::table($tabel)
            ->selectRaw("id_kec, $sum")
            ->where('periode', 2026)
            ->whereNotNull('id_kel')
            ->groupBy('id_kec')
            ->get()
            ->keyBy('id_kec');
    }
}