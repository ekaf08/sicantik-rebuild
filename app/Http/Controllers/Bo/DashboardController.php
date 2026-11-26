<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Support\Pokja1;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Bo\Pokja2Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $kecamatan = DB::table('m_kecamatan')
            ->whereNull('deleted_at')
            ->orderBy('nama_kec')
            ->get();

        $kolom       = $this->kolom('data_umum_2026');
        $kolomPokja1 = $this->kolom('d_pokja_1_2026');
        $kolomPokja2 = $this->kolom('d_pokja_2_2026');
        $kolomPokja4 = $this->kolom('d_pokja_4_2026');

        // Deteksi akun Kelurahan / Kecamatan lebih dulu supaya key data sesuai $baris
        $user        = Auth::user();
        $level       = 'kecamatan';
        $baris       = $kecamatan;
        $kecAktif    = null;
        $idKelFilter = null;

        if (!empty($user->id_kel)) {
            $level       = 'kelurahan';
            $idKelFilter = (int) $user->id_kel;
            $kecAktif    = DB::table('m_kecamatan')->where('id_kec', $user->id_kec)->first();
            $baris       = DB::table('m_kelurahan')->where('id_kel', $idKelFilter)->get();
        } elseif (!empty($user->id_kec) && (int) $user->id_kec !== 32) {
            $level    = 'kelurahan';
            $kecAktif = DB::table('m_kecamatan')->where('id_kec', $user->id_kec)->first();
            $baris    = DB::table('m_kelurahan')
                ->where('kode_kec_bpjs', $kecAktif->kode_bpjs ?? '')
                ->orderBy('nama_kel')
                ->get();
        }

        if ($level === 'kelurahan' && $kecAktif) {
            $rekap = $this->rekapLevelKelurahan($baris, (int) $kecAktif->id_kec, $idKelFilter, $kolomPokja2);

            return view('bo.pages.dashboard', [
                'level'       => $level,
                'kec'         => $kecAktif,
                'baris'       => $baris,
                'kecamatan'   => $kecamatan,
                'kolom'       => $kolom,
                'data'        => $rekap['data'],
                'kolomPokja1' => $kolomPokja1,
                'dataPokja1'  => $rekap['dataPokja1'],
                'kolomPokja2' => $kolomPokja2,
                'dataPokja2'  => $rekap['dataPokja2'],
                'kolomPokja3' => $rekap['kolomPokja3'],
                'dataPokja3'  => $rekap['dataPokja3'],
                'kolomPokja4' => $kolomPokja4,
                'dataPokja4'  => $rekap['dataPokja4'],
            ]);
        }

        // ===== Level Kota (key = id_kec) =====
        $data = $this->sumPerKecamatan('data_umum_2026', $kolom);

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
            $data[$r->id_kec]->kk            = $r->kk;
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

        $dataPokja1 = Pokja1::perKecamatan();

        $dataPokja2 = collect();
        foreach ($kecamatan as $kec) {
            $o = (object) ['id_kec' => $kec->id_kec];
            foreach ($kolomPokja2 as $k) {
                $o->{$k->alias} = 0;
            }
            $dataPokja2[$kec->id_kec] = $o;
        }

        $mapPokja2 = [
            'warga_3_buta' => 'warga_buta',         'tpk3_pkk' => 'tpk3_pkk',
            'damas_pkk' => 'damas_pkk',             'pemula_psrt' => 'up2k_pemula',
            'madya_psrt' => 'up2k_madya',           'anggota' => 'koperasi_anggota',
            'tutor_kf' => 'tutor_kf',               'kader_koperasi' => 'kader_koperasi',
            'kader_keterampilan' => 'kader_keterampilan',
            'kader_bkb' => 'kader_bkb',             'lp3_pkk' => 'lp3_pkk',
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

        $bkbKelp = DB::table('kelompok_bkb')
            ->whereNotNull('id_kec')
            ->selectRaw('id_kec, COUNT(*) AS kelp')
            ->groupBy('id_kec')
            ->pluck('kelp', 'id_kec');

        foreach ($bkbKelp as $idKec => $kelp) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->bkb_kelp = $kelp;
        }

        $ibu = DB::table('peserta_bkb')
            ->whereNotNull('id_kec')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')
            ->pluck('total', 'id_kec');

        foreach ($ibu as $idKec => $total) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->bkb_ibu_peserta = $total;
        }

        // BKB Jml Kelp & Jml APE dari tabel tarikan kelompok_bkb
        $bkbTarik = DB::table('kelompok_bkb')
            ->whereNotNull('id_kec')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')
            ->pluck('total', 'id_kec');

        foreach ($bkbTarik as $idKec => $total) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->bkb_kelp = $total;
            $dataPokja2[$idKec]->bkb_ape  = $total;
        }

        // BKB Jml Kelp Simulasi dari tabel tarikan jumlah_soth_2
        $bkbSimulasi = DB::table('jumlah_soth_2')
            ->whereNotNull('id_kec')
            ->selectRaw('id_kec, COUNT(*) AS simulasi')
            ->groupBy('id_kec')
            ->pluck('simulasi', 'id_kec');

        foreach ($bkbSimulasi as $idKec => $simulasi) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->bkb_kelp_simulasi = $simulasi;
        }

        // Pokja 2: Kelompok Belajar & Warga Belajar (Paket A, B, C dari tabel tarikan)
        $tabelBelajar = [
            'paket_a_klp'   => 'm_detail_kelompok_belajar_a',
            'paket_b_klp'   => 'm_detail_kelompok_belajar_b',
            'paket_c_klp'   => 'm_detail_kelompok_belajar_c',
            'paket_a_warga' => 'm_detail_warga_belajar_a',
            'paket_b_warga' => 'm_detail_warga_belajar_b',
            'paket_c_warga' => 'm_detail_warga_belajar_c',
        ];

        foreach ($tabelBelajar as $alias => $namaTabel) {
            $rows = DB::table($namaTabel)
                ->whereNotNull('id_kec')
                ->selectRaw('id_kec, COUNT(*) AS total')
                ->groupBy('id_kec')
                ->pluck('total', 'id_kec');

            foreach ($rows as $idKec => $total) {
                if (!$dataPokja2->has($idKec)) {
                    $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
                }
                $dataPokja2[$idKec]->$alias = $total;
            }
        }

        // Pokja 2: KF (Kelompok Belajar & Warga Belajar)
        $tabelKf = [
            'kf_klp'   => 'm_kelompok_belajar_pokja2_kf',
            'kf_warga' => 'm_warga_belajar_pokja2_kf',
        ];

        foreach ($tabelKf as $alias => $namaTabel) {
            $rows = DB::table($namaTabel)
                ->where('periode', 2026)
                ->whereNull('deleted_at')
                ->whereNotNull('id_kec')
                ->selectRaw('id_kec, COUNT(*) AS total')
                ->groupBy('id_kec')
                ->pluck('total', 'id_kec');

            foreach ($rows as $idKec => $total) {
                if (!$dataPokja2->has($idKec)) {
                    $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
                }
                $dataPokja2[$idKec]->$alias = $total;
            }
        }

        // PAUD Sejenis dari m_detail_paud_perkelurahan
        $paud = DB::table('m_detail_paud_perkelurahan')
            ->whereNotNull('id_kec')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')
            ->pluck('total', 'id_kec');

        foreach ($paud as $idKec => $total) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->paud_sejenis = $total;
        }

        // Tutor PAUD tetap dari d_paud_2026
        $tutorPaud = DB::table('d_paud_2026')
            ->where('periode', 2026)->whereNull('deleted_at')
            ->whereNotNull('nama_pegawai')
            ->selectRaw('id_kec, COUNT(*) AS tutor')
            ->groupBy('id_kec')
            ->pluck('tutor', 'id_kec');

        foreach ($tutorPaud as $idKec => $tutor) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->tutor_paud_sejenis = $tutor;
        }

        $tb = DB::table('m_detail_taman_bacaan')
            ->whereNotNull('id_kec')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')
            ->pluck('total', 'id_kec');

        foreach ($tb as $idKec => $total) {
            if (!$dataPokja2->has($idKec)) {
                $dataPokja2[$idKec] = (object) ['id_kec' => $idKec];
            }
            $dataPokja2[$idKec]->taman_bacaan = $total;
        }

        $pokja3      = Pokja3Controller::getRekapData(2026);
        $kolomPokja3 = $pokja3['kolomPokja3'];
        $dataPokja3  = $pokja3['dataPokja3'];
        $dataPokja4  = Pokja4Controller::getRekapData(2026);

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

    private function rekapLevelKelurahan($baris, int $idKec, ?int $idKel, $kolomPokja2): array
    {
        $filterKel = fn ($q) => $q->when($idKel !== null, fn ($q) => $q->where('id_kel', $idKel));

        // Data Umum per kelurahan
        $data = DB::table('data_umum_2026')
            ->where('id_kec', $idKec)
            ->where('periode', 2026)
            ->whereNotNull('id_kel')
            ->tap($filterKel)
            ->get()
            ->keyBy('id_kel');

        foreach ($baris as $kel) {
            if ($data->has($kel->id_kel)) {
                $data[$kel->id_kel]->kelurahan = 1;
            } else {
                $data[$kel->id_kel] = (object) ['id_kel' => $kel->id_kel, 'kelurahan' => 1];
            }
        }

        $jmlDasaWisma = DB::table('d_dasa_wisma_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')->pluck('total', 'id_kel');

        foreach ($baris as $kel) {
            $data[$kel->id_kel]->dasa_wisma = $jmlDasaWisma[$kel->id_kel] ?? 0;
        }

        $kader = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->tap($filterKel)
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
            ->tap($filterKel)
            ->selectRaw("id_kel,
                COUNT(*) FILTER (WHERE kepala_keluarga) AS kk,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'L') AS jumlah_jiwa_l,
                COUNT(*) FILTER (WHERE jenis_kelamin = 'P') AS jumlah_jiwa_p")
            ->groupBy('id_kel')->get();

        foreach ($pend as $r) {
            if (!$data->has($r->id_kel)) {
                $data[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $data[$r->id_kel]->kk            = $r->kk;
            $data[$r->id_kel]->jumlah_jiwa_l = $r->jumlah_jiwa_l;
            $data[$r->id_kel]->jumlah_jiwa_p = $r->jumlah_jiwa_p;
        }

        $rw = DB::table('d_lembaga_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)
            ->where('jenis', 'rw')->whereNull('deleted_at')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')->pluck('total', 'id_kel');

        foreach ($rw as $kelId => $total) {
            if (!$data->has($kelId)) {
                $data[$kelId] = (object) ['id_kel' => $kelId];
            }
            $data[$kelId]->rw = $total;
        }

        // Pokja 2 per kelurahan
        $dataPokja2 = collect();
        foreach ($baris as $kel) {
            $o = (object) ['id_kel' => $kel->id_kel];
            foreach ($kolomPokja2 as $k) {
                $o->{$k->alias} = 0;
            }
            $dataPokja2[$kel->id_kel] = $o;
        }

        $mapPokja2 = [
            'warga_3_buta' => 'warga_buta',         'tpk3_pkk' => 'tpk3_pkk',
            'damas_pkk' => 'damas_pkk',             'pemula_psrt' => 'up2k_pemula',
            'madya_psrt' => 'up2k_madya',           'anggota' => 'koperasi_anggota',
            'tutor_kf' => 'tutor_kf',               'kader_koperasi' => 'kader_koperasi',
            'kader_keterampilan' => 'kader_keterampilan',
            'kader_bkb' => 'kader_bkb',             'lp3_pkk' => 'lp3_pkk',
        ];

        $cacah = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->tap($filterKel)
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

        $bkbKelp = DB::table('kelompok_bkb')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS kelp')
            ->groupBy('id_kel')
            ->pluck('kelp', 'id_kel');

        foreach ($bkbKelp as $kelId => $kelp) {
            if (!$dataPokja2->has($kelId)) {
                $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
            }
            $dataPokja2[$kelId]->bkb_kelp = $kelp;
        }

        $ibu = DB::table('peserta_bkb')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')
            ->pluck('total', 'id_kel');

        foreach ($ibu as $kelId => $total) {
            if (!$dataPokja2->has($kelId)) {
                $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
            }
            $dataPokja2[$kelId]->bkb_ibu_peserta = $total;
        }

        // BKB Jml Kelp & Jml APE dari tabel tarikan kelompok_bkb
        $bkbTarik = DB::table('kelompok_bkb')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')
            ->pluck('total', 'id_kel');

        foreach ($bkbTarik as $kelId => $total) {
            if (!$dataPokja2->has($kelId)) {
                $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
            }
            $dataPokja2[$kelId]->bkb_kelp = $total;
            $dataPokja2[$kelId]->bkb_ape  = $total;
        }

        // BKB Jml Kelp Simulasi dari tabel tarikan jumlah_soth_2
        $bkbSimulasi = DB::table('jumlah_soth_2')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS simulasi')
            ->groupBy('id_kel')
            ->pluck('simulasi', 'id_kel');

        foreach ($bkbSimulasi as $kelId => $simulasi) {
            if (!$dataPokja2->has($kelId)) {
                $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
            }
            $dataPokja2[$kelId]->bkb_kelp_simulasi = $simulasi;
        }

       $tabelBelajar = [
            'paket_a_klp'   => 'm_detail_kelompok_belajar_a',
            'paket_b_klp'   => 'm_detail_kelompok_belajar_b',
            'paket_c_klp'   => 'm_detail_kelompok_belajar_c',
            'paket_a_warga' => 'm_detail_warga_belajar_a',
            'paket_b_warga' => 'm_detail_warga_belajar_b',
            'paket_c_warga' => 'm_detail_warga_belajar_c',
        ];

        foreach ($tabelBelajar as $alias => $namaTabel) {
            $rows = DB::table($namaTabel)
                ->where('id_kec', $idKec)
                ->whereNotNull('id_kel')
                ->tap($filterKel)
                ->selectRaw('id_kel, COUNT(*) AS total')
                ->groupBy('id_kel')
                ->pluck('total', 'id_kel');

            foreach ($rows as $kelId => $total) {
                if (!$dataPokja2->has($kelId)) {
                    $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
                }
                $dataPokja2[$kelId]->$alias = $total;
            }
        }

        // Pokja 2: KF (Kelompok Belajar & Warga Belajar)
        $tabelKf = [
            'kf_klp'   => 'm_kelompok_belajar_pokja2_kf',
            'kf_warga' => 'm_warga_belajar_pokja2_kf',
        ];

        foreach ($tabelKf as $alias => $namaTabel) {
            $rows = DB::table($namaTabel)
                ->where('id_kec', $idKec)
                ->where('periode', 2026)
                ->whereNull('deleted_at')
                ->whereNotNull('id_kel')
                ->tap($filterKel)
                ->selectRaw('id_kel, COUNT(*) AS total')
                ->groupBy('id_kel')
                ->pluck('total', 'id_kel');

            foreach ($rows as $kelId => $total) {
                if (!$dataPokja2->has($kelId)) {
                    $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
                }
                $dataPokja2[$kelId]->$alias = $total;
            }
        }

        // PAUD Sejenis dari m_detail_paud_perkelurahan
        $paud = DB::table('m_detail_paud_perkelurahan')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')
            ->pluck('total', 'id_kel');

        foreach ($paud as $kelId => $total) {
            if (!$dataPokja2->has($kelId)) {
                $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
            }
            $dataPokja2[$kelId]->paud_sejenis = $total;
        }

        // Tutor PAUD tetap dari d_paud_2026
        $tutorPaud = DB::table('d_paud_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)->whereNull('deleted_at')
            ->whereNotNull('nama_pegawai')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS tutor')
            ->groupBy('id_kel')
            ->pluck('tutor', 'id_kel');

        foreach ($tutorPaud as $kelId => $tutor) {
            if (!$dataPokja2->has($kelId)) {
                $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
            }
            $dataPokja2[$kelId]->tutor_paud_sejenis = $tutor;
        }

        $tb = DB::table('m_detail_taman_bacaan')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->tap($filterKel)
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')
            ->pluck('total', 'id_kel');

        foreach ($tb as $kelId => $total) {
            if (!$dataPokja2->has($kelId)) {
                $dataPokja2[$kelId] = (object) ['id_kel' => $kelId];
            }
            $dataPokja2[$kelId]->taman_bacaan = $total;
        }

        $pokja3 = Pokja3Controller::getRekapData(2026, $idKec);

        return [
            'data'        => $data,
            'dataPokja1'  => Pokja1::perKelurahan($idKec, 2026, $idKel),
            'dataPokja2'  => $dataPokja2,
            'kolomPokja3' => $pokja3['kolomPokja3'],
            'dataPokja3'  => $pokja3['dataPokja3'],
            'dataPokja4'  => Pokja4Controller::getRekapData(2026, $idKec, $idKel),
        ];
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