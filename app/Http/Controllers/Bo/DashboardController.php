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

        // Dasa Wisma: angka dihitung dari tabel detail, supaya sama dengan isi modal
        $jmlDasaWisma = DB::table('d_dasa_wisma_2026')
            ->where('periode', 2026)
            ->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')
            ->pluck('total', 'id_kec');

        foreach ($kecamatan as $kec) {
            $jml = $jmlDasaWisma[$kec->id_kec] ?? 0;

            if ($data->has($kec->id_kec)) {
                $data[$kec->id_kec]->dasa_wisma = $jml;
            } else {
                $data[$kec->id_kec] = (object) ['id_kec' => $kec->id_kec, 'dasa_wisma' => $jml];
            }
        }

        // Kader: angka dihitung dari tabel detail
        $kader = DB::table('d_kader_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kec, jenis_kader, jenis_kelamin, COUNT(*) AS total')
            ->groupBy('id_kec', 'jenis_kader', 'jenis_kelamin')
            ->get();

        foreach ($kader as $r) {
            $alias = $r->jenis_kader . '_' . strtolower($r->jenis_kelamin);
            if (!$data->has($r->id_kec)) {
                $data[$r->id_kec] = (object) ['id_kec' => $r->id_kec];
            }
            $data[$r->id_kec]->$alias = $r->total;
        }

        // Kolom Kelurahan: jumlah kelurahan asli dari m_kelurahan
        $jmlKelurahan = DB::table('m_kelurahan as l')
            ->join('m_kecamatan as k', 'k.kode_bpjs', '=', 'l.kode_kec_bpjs')
            ->selectRaw('k.id_kec, COUNT(*) AS total')
            ->groupBy('k.id_kec')
            ->pluck('total', 'id_kec');

        foreach ($kecamatan as $kec) {
            $jml = $jmlKelurahan[$kec->id_kec] ?? 0;

            if ($data->has($kec->id_kec)) {
                $data[$kec->id_kec]->kelurahan = $jml;
            } else {
                $data[$kec->id_kec] = (object) ['id_kec' => $kec->id_kec, 'kelurahan' => $jml];
            }
        }

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