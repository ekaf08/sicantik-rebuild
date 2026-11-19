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

        // Kader Pokja 1 per Kecamatan
        $kader = DB::table('d_kader_2026')
            ->where('periode', $tahun)
            ->where('jenis_kader', 'pengurus_pokja1')
            ->whereNull('id_kel')
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

        // Volume dari m_lotus (pakai flag_kolom & tahun)
        $lotus = DB::table('m_lotus')
            ->where('tahun', $tahun)
            ->whereNull('id_kec')
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

        // Jumlah Peserta dari peserta_lotus (pakai flag_kolom & tahun)
        $pes = DB::table('peserta_lotus')
            ->where('tahun', $tahun)
            ->whereNull('id_kec')
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

        // === BARIS TAMBAHAN: TP PKK KOTA (id_kec = 32, kolom kegiatan dikosongkan) ===
        $kaderKota = DB::table('d_kader_2026')
            ->where('id_kec', 32)
            ->whereNull('id_kel')
            ->where('periode', $tahun)
            ->where('jenis_kader', 'pengurus_pokja1')
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

        // Kader Pokja 1 per Kelurahan
        $kader = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)
            ->whereNotNull('id_kel')
            ->where('periode', $tahun)
            ->where('jenis_kader', 'pengurus_pokja1')
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

        // Volume dari m_lotus per Kelurahan
        $lotus = DB::table('m_lotus')
            ->where('id_kec', $idKec)
            ->whereNull('id_kel')
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

        // Jumlah Peserta dari peserta_lotus per Kelurahan
        $pes = DB::table('peserta_lotus')
            ->where('id_kec', $idKec)
            ->whereNull('id_kel')
            ->where('tahun', $tahun)
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

        $tpPkkKec->jumlah_kader = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)
            ->whereNull('id_kel')
            ->where('periode', $tahun)
            ->where('jenis_kader', 'pengurus_pokja1')
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
            ->whereNull('deleted_at')
            ->selectRaw('flag_kolom, COUNT(*) AS total')
            ->groupBy('flag_kolom')
            ->get();

        foreach ($pesKec as $r) {
            $tpPkkKec->{$r->flag_kolom . '_peserta'} = $r->total;
        }

        $data['tp_pkk'] = $tpPkkKec;

        return $data;
    }
}