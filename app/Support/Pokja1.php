<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class Pokja1
{
    private const GRUP = ['kisah', 'krisan', 'kilas', 'kiat', 'kisak', 'pkbn'];

    private static function cols(array $suffix): array
    {
        $c = [];
        foreach (self::GRUP as $g) {
            foreach ($suffix as $s) {
                $c[] = "{$g}_{$s}";
            }
        }
        return $c;
    }

    // Level kecamatan: teks dari baris id_kel kosong (is_row = 1), angka dari tabel detail + baris TP PKK KOTA
    public static function perKecamatan($tahun = 2026)
    {
        $sum = collect(self::cols(['volume', 'peserta']))
            ->map(fn ($c) => "COALESCE(SUM($c),0) AS $c")
            ->implode(', ');

        $data = DB::table('kegiatan_pokja1')
            ->whereNull('deleted_at')
            ->whereNull('id_kel')
            ->where('is_row', 1)
            ->selectRaw("id_kec, $sum")
            ->groupBy('id_kec')
            ->get()
            ->keyBy('id_kec');

        $teks = DB::table('kegiatan_pokja1')
            ->whereNull('deleted_at')
            ->whereNull('id_kel')
            ->where('flagnya', 'KECAMATAN')
            ->where('is_row', 1)
            ->orderBy('id')
            ->get();

        foreach ($teks as $r) {
            if (!$data->has($r->id_kec)) {
                $data[$r->id_kec] = (object) ['id_kec' => $r->id_kec];
            }
            $data[$r->id_kec]->id = $r->id;
            foreach (self::cols(['kegiatan', 'metode']) as $c) {
                $data[$r->id_kec]->$c = $r->$c;
            }
        }

        // Kader Pokja 1 per Kecamatan (total seluruh kelurahan + kecamatan dari kader_pokja_1_2026)
        $kader = DB::table('kader_pokja_1_2026')
            ->where('periode', $tahun)
            ->whereNotNull('nik')
            ->whereNotNull('jenis_kelamin')
            ->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(*) AS total')
            ->groupBy('id_kec')
            ->pluck('total', 'id_kec');

        foreach ($kader as $idKec => $total) {
            if (!$data->has($idKec)) {
                $data[$idKec] = (object) ['id_kec' => $idKec];
            }
            $data[$idKec]->jumlah_kader = $total;
        }

        // Volume dari m_lotus level kecamatan (id_kel IS NULL)
        $lotus = DB::table('m_lotus')
            ->where('tahun', $tahun)
            ->whereNull('id_kel')
            ->whereNull('deleted_at')
            ->selectRaw('id_kec, flag_kolom, COUNT(*) AS total')
            ->groupBy('id_kec', 'flag_kolom')
            ->get();

        foreach ($lotus as $r) {
            if (!$data->has($r->id_kec)) {
                $data[$r->id_kec] = (object) ['id_kec' => $r->id_kec];
            }
            $data[$r->id_kec]->{$r->flag_kolom . '_volume'} = $r->total;
        }

        // Jumlah Peserta dari peserta_lotus level kecamatan (kecuali kisak yang ambil dari ibu_hamil_resiko)
        $pes = DB::table('peserta_lotus')
            ->where('tahun', $tahun)
            ->where('flag_kolom', '!=', 'kisak')
            ->whereNull('id_kel')
            ->whereNull('deleted_at')
            ->selectRaw('id_kec, flag_kolom, COUNT(*) AS total')
            ->groupBy('id_kec', 'flag_kolom')
            ->get();

        foreach ($pes as $r) {
            if (!$data->has($r->id_kec)) {
                $data[$r->id_kec] = (object) ['id_kec' => $r->id_kec];
            }
            $data[$r->id_kec]->{$r->flag_kolom . '_peserta'} = $r->total;
        }

        // Jumlah KISAK (kisak_peserta) per Kecamatan dari tabel tarikan ibu_hamil_resiko
        $kisakKec = DB::table('ibu_hamil_resiko as ihr')
            ->join('m_kecamatan as k', DB::raw('UPPER(TRIM(k.nama_kec))'), '=', DB::raw('UPPER(TRIM(ihr.kecamatan))'))
            ->whereNull('k.deleted_at')
            ->selectRaw('k.id_kec, COUNT(*) AS total')
            ->groupBy('k.id_kec')
            ->pluck('total', 'id_kec');

        foreach ($kisakKec as $idKec => $total) {
            if (!$data->has($idKec)) {
                $data[$idKec] = (object) ['id_kec' => $idKec];
            }
            $data[$idKec]->kisak_peserta = $total;
        }

        // === BARIS TAMBAHAN: TP PKK KOTA (id_kec = 32, kolom kegiatan dikosongkan) ===
        $kaderKota = DB::table('kader_pokja_1_2026')
            ->where('id_kec', 32)
            ->whereNull('id_kel')
            ->where('periode', $tahun)
            ->whereNotNull('nik')
            ->whereNotNull('jenis_kelamin')
            ->whereNull('deleted_at')
            ->count();

        $tpPkkKota = (object) [
            'id_kec'       => 32,
            'id_kel'       => null,
            'jumlah_kader' => $kaderKota,
        ];
        foreach (self::cols(['kegiatan', 'volume', 'metode', 'peserta']) as $c) {
            $tpPkkKota->$c = null;
        }
        $data['tp_pkk'] = $tpPkkKota;

        return $data;
    }

    // Level kelurahan: satu baris kegiatan_pokja1 per id_kel (is_row = 1) + baris TP PKK KECAMATAN
    public static function perKelurahan($idKec, $tahun = 2026, $onlyIdKel = null)
    {
        $data = DB::table('kegiatan_pokja1')
            ->where('id_kec', $idKec)
            ->whereNull('deleted_at')
            ->whereNotNull('id_kel')
            ->where('flagnya', 'KELURAHAN')
            ->where('is_row', 1)
            ->orderBy('id')
            ->get()
            ->keyBy('id_kel');

        // Kader Pokja 1 per Kelurahan (dari kader_pokja_1_2026)
        $kader = DB::table('kader_pokja_1_2026')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->where('periode', $tahun)
            ->whereNotNull('nik')
            ->whereNotNull('jenis_kelamin')
            ->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS total')
            ->groupBy('id_kel')
            ->pluck('total', 'id_kel');

        foreach ($kader as $idKel => $total) {
            if (!$data->has($idKel)) {
                $data[$idKel] = (object) ['id_kel' => $idKel];
            }
            $data[$idKel]->jumlah_kader = $total;
        }

        // Volume dari m_lotus per Kelurahan (id_kel NOT NULL)
        $lotus = DB::table('m_lotus')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->where('tahun', $tahun)
            ->whereNull('deleted_at')
            ->selectRaw('id_kel, flag_kolom, COUNT(*) AS total')
            ->groupBy('id_kel', 'flag_kolom')
            ->get();

        foreach ($lotus as $r) {
            if (!$data->has($r->id_kel)) {
                $data[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $data[$r->id_kel]->{$r->flag_kolom . '_volume'} = $r->total;
        }

        // Jumlah Peserta dari peserta_lotus per Kelurahan (kecuali kisak yang ambil dari ibu_hamil_resiko)
        $pes = DB::table('peserta_lotus')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->where('tahun', $tahun)
            ->where('flag_kolom', '!=', 'kisak')
            ->whereNull('deleted_at')
            ->selectRaw('id_kel, flag_kolom, COUNT(*) AS total')
            ->groupBy('id_kel', 'flag_kolom')
            ->get();

        foreach ($pes as $r) {
            if (!$data->has($r->id_kel)) {
                $data[$r->id_kel] = (object) ['id_kel' => $r->id_kel];
            }
            $data[$r->id_kel]->{$r->flag_kolom . '_peserta'} = $r->total;
        }

        // Jumlah KISAK (kisak_peserta) per Kelurahan dari tabel tarikan ibu_hamil_resiko
        $kecRow = DB::table('m_kecamatan')->where('id_kec', $idKec)->first();
        if ($kecRow) {
            $kisakKel = DB::table('ibu_hamil_resiko as ihr')
                ->join('m_kelurahan as l', function ($join) use ($kecRow) {
                    $join->on(DB::raw('UPPER(TRIM(l.nama_kel))'), '=', DB::raw('UPPER(TRIM(ihr.kelurahan))'))
                         ->where('l.kode_kec_bpjs', '=', $kecRow->kode_bpjs);
                })
                ->whereRaw('UPPER(TRIM(ihr.kecamatan)) = ?', [strtoupper(trim($kecRow->nama_kec))])
                ->selectRaw('l.id_kel, COUNT(*) AS total')
                ->groupBy('l.id_kel')
                ->pluck('total', 'id_kel');

            foreach ($kisakKel as $idKel => $total) {
                if (!$data->has($idKel)) {
                    $data[$idKel] = (object) ['id_kel' => $idKel];
                }
                $data[$idKel]->kisak_peserta = $total;
            }
        }

        // Jika login sebagai akun Kelurahan tertentu, hanya kembalikan kelurahan itu (tanpa TP PKK Kecamatan)
        if (!empty($onlyIdKel)) {
            return $data->only([(int) $onlyIdKel]);
        }

        // === BARIS TAMBAHAN: TP PKK KECAMATAN (id_kel IS NULL, is_row = 1) ===
        $tpPkkKec = DB::table('kegiatan_pokja1')
            ->where('id_kec', $idKec)
            ->whereNull('id_kel')
            ->where('flagnya', 'KECAMATAN')
            ->where('is_row', 1)
            ->whereNull('deleted_at')
            ->first();

        if (!$tpPkkKec) {
            $tpPkkKec = (object) ['id' => null, 'id_kec' => $idKec, 'id_kel' => null];
        }

        $tpPkkKec->jumlah_kader = DB::table('kader_pokja_1_2026')
            ->where('id_kec', $idKec)
            ->whereNull('id_kel')
            ->where('periode', $tahun)
            ->whereNotNull('nik')
            ->whereNotNull('jenis_kelamin')
            ->whereNull('deleted_at')
            ->count();

        $lotusKec = DB::table('m_lotus')
            ->where('id_kec', $idKec)
            ->whereNull('id_kel')
            ->where('tahun', $tahun)
            ->whereNull('deleted_at')
            ->selectRaw('flag_kolom, COUNT(*) AS total')
            ->groupBy('flag_kolom')
            ->get();

        foreach ($lotusKec as $r) {
            $tpPkkKec->{$r->flag_kolom . '_volume'} = $r->total;
        }

        $pesKec = DB::table('peserta_lotus')
            ->where('id_kec', $idKec)
            ->whereNull('id_kel')
            ->where('tahun', $tahun)
            ->where('flag_kolom', '!=', 'kisak')
            ->whereNull('deleted_at')
            ->selectRaw('flag_kolom, COUNT(*) AS total')
            ->groupBy('flag_kolom')
            ->get();

        foreach ($pesKec as $r) {
            $tpPkkKec->{$r->flag_kolom . '_peserta'} = $r->total;
        }

        // KISAK di baris TP PKK Kecamatan (data yang kelurahannya kosong/tidak terpetakan di kecamatan tsb)
        if ($kecRow) {
            $tpPkkKec->kisak_peserta = DB::table('ibu_hamil_resiko')
                ->whereRaw('UPPER(TRIM(kecamatan)) = ?', [strtoupper(trim($kecRow->nama_kec))])
                ->where(function ($q) {
                    $q->whereNull('kelurahan')->orWhereRaw("TRIM(kelurahan) = ''");
                })
                ->count();
        }

        $data['tp_pkk'] = $tpPkkKec;

        return $data;
    }
}