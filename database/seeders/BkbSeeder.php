<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BkbSeeder extends Seeder
{
    public function run(): void
    {
        // hanya dua tabel milik sendiri
        DB::table('d_bkb_ibu_2026')->delete();
        DB::table('d_bkb_kelompok_2026')->delete();

        $now = now();

        // [id_kel, nama, ape, simulasi]
        $kelompok = [
            [101, 'BKB Melati',  3, true],
            [101, 'BKB Mawar',   2, false],
            [102, 'BKB Anggrek', 4, true],
            [100, 'BKB Kenanga', 0, false],
            [103, 'BKB Dahlia',  1, true],
        ];

        $idKelompok = [];
        foreach ($kelompok as $i => [$kel, $nama, $ape, $sim]) {
            $idKelompok[$i] = DB::table('d_bkb_kelompok_2026')->insertGetId([
                'id_kec' => 19, 'id_kel' => $kel, 'periode' => 2026,
                'nama_kelompok' => $nama, 'alamat_jalan' => "Jl. $nama",
                'rt' => '1', 'rw' => '2', 'pembina' => 'Ibu Pembina',
                'nomor_sk' => 'SK/' . ($i + 1) . '/2026', 'nama_ketua' => 'Ketua ' . $nama,
                'jumlah_ape' => $ape, 'is_simulasi' => $sim,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // [index kelompok, id_kel, nik, nama, nama anak]
        $ibu = [
            [0, 101, '3578010101900001', 'Ratna',   'Aldi'],
            [0, 101, '3578010101900002', 'Wulan',   'Bima'],
            [1, 101, '3578010101900003', 'Yuni',    'Citra'],
            [2, 102, '3578010101900004', 'Sari',    'Dimas'],
            [2, 102, '3578010101900005', 'Indah',   'Eka'],
            [3, 100, '3578010101900006', 'Fitri',   'Fajar'],
            [4, 103, '3578010101900007', 'Lestari', 'Gita'],
            [4, 103, '3578010101900008', 'Nanda',   'Hana'],
        ];

        $rows = [];
        foreach ($ibu as [$k, $kel, $nik, $nama, $anak]) {
            $rows[] = [
                'id_kec' => 19, 'id_kel' => $kel, 'periode' => 2026,
                'id_kelompok' => $idKelompok[$k], 'nik' => $nik,
                'nama' => $nama, 'nama_anak' => $anak,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }
        DB::table('d_bkb_ibu_2026')->insert($rows);
    }
}