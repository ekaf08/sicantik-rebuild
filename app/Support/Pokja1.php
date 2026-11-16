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
            foreach ($suffix as $s) { $c[] = "{$g}_{$s}"; }
        }
        return $c;
    }

    // Level kecamatan: angka = SUM semua baris kecamatan, teks dari baris id_kel kosong
    public static function perKecamatan()
    {
        $sum = collect(self::cols(['volume', 'peserta']))
            ->map(fn ($c) => "COALESCE(SUM($c),0) AS $c")->implode(', ');

        $data = DB::table('kegiatan_pokja1')
            ->whereNull('deleted_at')
            ->selectRaw("id_kec, $sum")
            ->groupBy('id_kec')->get()->keyBy('id_kec');

        $teks = DB::table('kegiatan_pokja1')
            ->whereNull('deleted_at')->whereNull('id_kel')
            ->orderBy('id')->get();                       // yang terbaru menang

        foreach ($teks as $r) {
            if (!$data->has($r->id_kec)) { $data[$r->id_kec] = (object) ['id_kec' => $r->id_kec]; }
            foreach (self::cols(['kegiatan', 'metode']) as $c) { $data[$r->id_kec]->$c = $r->$c; }
        }

        $kader = DB::table('d_kader_2026')
            ->where('periode', 2026)->where('jenis_kader', 'pengurus_pokja1')->whereNull('deleted_at')
            ->selectRaw('id_kec, COUNT(*) AS total')->groupBy('id_kec')->pluck('total', 'id_kec');
        foreach ($kader as $idKec => $total) {
            if (!$data->has($idKec)) { $data[$idKec] = (object) ['id_kec' => $idKec]; }
            $data[$idKec]->jumlah_kader = $total;
        }

        return $data;
    }

    // Level kelurahan: satu baris kegiatan_pokja1 per id_kel
    public static function perKelurahan($idKec)
    {
        $data = DB::table('kegiatan_pokja1')
            ->where('id_kec', $idKec)->whereNull('deleted_at')->whereNotNull('id_kel')
            ->orderBy('id')->get()->keyBy('id_kel');

        $kader = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)->where('periode', 2026)
            ->where('jenis_kader', 'pengurus_pokja1')->whereNull('deleted_at')
            ->selectRaw('id_kel, COUNT(*) AS total')->groupBy('id_kel')->pluck('total', 'id_kel');
        foreach ($kader as $idKel => $total) {
            if (!$data->has($idKel)) { $data[$idKel] = (object) ['id_kel' => $idKel]; }
            $data[$idKel]->jumlah_kader = $total;
        }

        return $data;
    }
}