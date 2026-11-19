<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Support\Pokja1;
use App\Http\Controllers\Bo\Pokja3Controller;
use Illuminate\Support\Facades\Auth;

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

        // Penduduk: KK dan jumlah jiwa dari tabel detail
        $pend = DB::table('d_penduduk_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw("id_kec,
                COUNT(*) FILTER (WHERE kepala_keluarga) AS kk,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'L') AS jumlah_jiwa_l,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'P') AS jumlah_jiwa_p")
            ->groupBy('id_kec')
            ->get();

        foreach ($pend as $r) {
            if (!$data->has($r->id_kec)) {
                $data[$r->id_kec] = (object) ['id_kec' => $r->id_kec];
            }
            $data[$r->id_kec]->kk = $r->kk;
            $data[$r->id_kec]->jumlah_jiwa_l = $r->jumlah_jiwa_l;
            $data[$r->id_kec]->jumlah_jiwa_p = $r->jumlah_jiwa_p;
        }

        $rw = DB::table('d_lembaga_2026')
            ->where('periode', 2026)->where('jenis', 'rw')->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')->pluck('total', 'id_kec');

        foreach ($rw as $idKec => $total) {
            if (!$data->has($idKec)) {
                $data[$idKec] = (object) ['id_kec' => $idKec];
            }
            $data[$idKec]->rw = $total;
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
        $dataPokja1  = Pokja1::perKecamatan();

        $kolomPokja2 = $this->kolom('d_pokja_2_2026');
        //$dataPokja2  = DB::table('d_pokja_2_2026')
        //    ->where('periode', 2026)
        //    ->get()
        //    ->keyBy('id_kec');

        $dataPokja2 = collect();
        foreach ($kecamatan as $kec) {
            $o = (object) ['id_kec' => $kec->id_kec];
            foreach ($kolomPokja2 as $k) { $o->{$k->alias} = 0; }
            $dataPokja2[$kec->id_kec] = $o;
        }

        // Pokja 2: angka dari d_kader_2026, alias kolom => jenis_kader
        $mapPokja2 = [
            'warga_3_buta' => 'warga_buta',   'tpk3_pkk' => 'tpk3_pkk',
            'damas_pkk' => 'damas_pkk',       'pemula_psrt' => 'up2k_pemula',
            'madya_psrt' => 'up2k_madya',     'anggota' => 'koperasi_anggota',
            'tutor_kf' => 'tutor_kf',         'kader_koperasi' => 'kader_koperasi',
            'kader_keterampilan' => 'kader_keterampilan',
            'kader_bkb' => 'kader_bkb',       'lp3_pkk' => 'lp3_pkk',
        ];

        $cacahPokja2 = DB::table('d_kader_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->whereIn('jenis_kader', array_values($mapPokja2))
            ->selectRaw('id_kec, jenis_kader, COUNT(*) AS total')
            ->groupBy('id_kec', 'jenis_kader')->get();

        $aliasDariJenis = array_flip($mapPokja2);
        foreach ($cacahPokja2 as $r) {
            if (!$dataPokja2->has($r->id_kec)) {
                $dataPokja2[$r->id_kec] = (object) ['id_kec' => $r->id_kec];
            }
            $dataPokja2[$r->id_kec]->{$aliasDariJenis[$r->jenis_kader]} = $r->total;
        }

        // Pokja 2: BKB dari tabel kelompok dan ibu
        $bkb = DB::table('d_bkb_kelompok_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(*) AS kelp, COALESCE(SUM(jumlah_ape),0) AS ape,
                        COUNT(*) FILTER (WHERE is_simulasi) AS simulasi')
            ->groupBy('id_kec')->get();

        foreach ($bkb as $r) {
            if (!$dataPokja2->has($r->id_kec)) {
                $dataPokja2[$r->id_kec] = (object) ['id_kec' => $r->id_kec];
            }
            $dataPokja2[$r->id_kec]->bkb_kelp = $r->kelp;
            $dataPokja2[$r->id_kec]->bkb_ape = $r->ape;
            $dataPokja2[$r->id_kec]->bkb_kelp_simulasi = $r->simulasi;
        }

        $ibu = DB::table('d_bkb_ibu_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')->pluck('total', 'id_kec');

        foreach ($ibu as $idKec => $total) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->bkb_ibu_peserta = $total;
        }

        // Pokja 2: PAUD, taman bacaan, kelompok dan warga belajar
        // Pokja 2: kelompok belajar, dihitung per id_pertanyaan
        $kl = DB::table('d_kelompok_belajar_2026 as d')
            ->join('m_pertanyaan_dashboard_2026 as p', 'p.id', '=', 'd.id_pertanyaan')
            ->where('d.periode', 2026)->whereNull('d.deleted_at')
            ->selectRaw('d.id_kec, p.alias, COUNT(*) AS total')
            ->groupBy('d.id_kec', 'p.alias')->get();

        foreach ($kl as $r) {
            if (!$dataPokja2->has($r->id_kec)) { $dataPokja2[$r->id_kec] = (object) ['id_kec' => $r->id_kec]; }
            $dataPokja2[$r->id_kec]->{$r->alias} = $r->total;
        }

        $wb = DB::table('d_warga_belajar_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kec, jenis_paket, COUNT(*) AS total')
            ->groupBy('id_kec', 'jenis_paket')->get();
        foreach ($wb as $r) {
            $p = strtolower($r->jenis_paket);
            $alias = $p === 'kf' ? 'kf_warga' : "paket_{$p}_warga";
            if (!$dataPokja2->has($r->id_kec)) { $dataPokja2[$r->id_kec] = (object) ['id_kec' => $r->id_kec]; }
            $dataPokja2[$r->id_kec]->$alias = $r->total;
        }

        $pd = DB::table('d_paud_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(DISTINCT npsn) AS lembaga,
                        COUNT(*) FILTER (WHERE nama_pegawai IS NOT NULL) AS tutor')
            ->groupBy('id_kec')->get();
        foreach ($pd as $r) {
            if (!$dataPokja2->has($r->id_kec)) { $dataPokja2[$r->id_kec] = (object) ['id_kec' => $r->id_kec]; }
            $dataPokja2[$r->id_kec]->paud_sejenis = $r->lembaga;
            $dataPokja2[$r->id_kec]->tutor_paud_sejenis = $r->tutor;
        }

        $tb = DB::table('d_taman_bacaan_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(*) AS total')->groupBy('id_kec')->pluck('total', 'id_kec');
        foreach ($tb as $idKec => $total) {
            if (!$dataPokja2->has($idKec)) { $dataPokja2[$idKec] = (object) ['id_kec' => $idKec]; }
            $dataPokja2[$idKec]->taman_bacaan = $total;
        }

        // Pokja 3 dan 4 
        $pokja3      = Pokja3Controller::getRekapData(2026);
        $kolomPokja3 = $pokja3['kolomPokja3'];
        $dataPokja3  = $pokja3['dataPokja3'];

        // Pokja 4
        $kolomPokja4 = $this->kolom('d_pokja_4_2026');
        $dataPokja4  = $this->sumPerKecamatan('d_pokja_4_2026', $kolomPokja4);

        // === TAMBAHAN: Deteksi akun Kelurahan / Kecamatan ===
        $user     = Auth::user();
        $level    = 'kecamatan';
        $baris    = $kecamatan;
        $kecAktif = null;

        if (!empty($user->id_kel)) {
            // Akun Kelurahan: tampilkan 1 kelurahan miliknya saja (tanpa TP PKK Kecamatan)
            $level      = 'kelurahan';
            $kecAktif   = DB::table('m_kecamatan')->where('id_kec', $user->id_kec)->first();
            $baris      = DB::table('m_kelurahan')->where('id_kel', $user->id_kel)->get();
            $dataPokja1 = Pokja1::perKelurahan($user->id_kec, 2026, $user->id_kel);
        } elseif (!empty($user->id_kec) && (int) $user->id_kec !== 32) {
            // Akun Kecamatan: tampilkan semua kelurahan di kecamatannya + TP PKK Kecamatan
            $level      = 'kelurahan';
            $kecAktif   = DB::table('m_kecamatan')->where('id_kec', $user->id_kec)->first();
            $baris      = DB::table('m_kelurahan')->where('kode_kec_bpjs', $kecAktif->kode_bpjs ?? '')->orderBy('nama_kel')->get();
            $dataPokja1 = Pokja1::perKelurahan($user->id_kec, 2026);
        }

        return view('bo.pages.dashboard', [
            'level'       => $level,
            'kec'         => $kecAktif,
            'baris'       => $baris,
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