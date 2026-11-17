<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('d_lotus_2026')->delete(); // hanya tabel milik sendiri

        $now  = now();
        $rows = [];
        $n    = 0;

        foreach (['kisah', 'krisan', 'kilas', 'kiat', 'kisak', 'pkbn'] as $g) {
            foreach ([101, 102, 100, 103] as $kel) {
                $jumlah = ($kel % 2) + 1;           // 1 sampai 2 per kelurahan
                for ($i = 1; $i <= $jumlah; $i++) {
                    $n++;
                    $rows[] = [
                        'id_kec' => 19, 'id_kel' => $kel, 'periode' => 2026,
                        'kelompok' => $g, 'nama' => strtoupper($g) . " Lotus $n",
                        'alamat' => "Jl. Contoh $n", 'rw' => (string) $i,
                        'tahap' => 'Tahap ' . (($n % 3) + 1),
                        'created_at' => $now, 'updated_at' => $now,
                    ];
                }
            }
        }

        DB::table('d_lotus_2026')->insert($rows);
    }
}