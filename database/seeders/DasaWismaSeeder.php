<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DasaWismaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('d_dasa_wisma_2026')->delete();

        $now = now();

        DB::table('d_dasa_wisma_2026')->insert([
            ['id_kec' => 19, 'id_kel' => 101, 'periode' => 2026, 'nama_dasawisma' => 'Melati 1',
             'rw' => '1', 'rt' => '1', 'nik_koordinator' => '3578010101010001',
             'nama_koordinator' => 'Siti Aminah', 'created_at' => $now, 'updated_at' => $now],
            ['id_kec' => 19, 'id_kel' => 101, 'periode' => 2026, 'nama_dasawisma' => 'Melati 2',
             'rw' => '1', 'rt' => '2', 'nik_koordinator' => '3578010101010002',
             'nama_koordinator' => 'Rina Wati', 'created_at' => $now, 'updated_at' => $now],
            ['id_kec' => 19, 'id_kel' => 102, 'periode' => 2026, 'nama_dasawisma' => 'Mawar 1',
             'rw' => '2', 'rt' => '1', 'nik_koordinator' => '3578010101010003',
             'nama_koordinator' => 'Dewi Lestari', 'created_at' => $now, 'updated_at' => $now],
            ['id_kec' => 19, 'id_kel' => 100, 'periode' => 2026, 'nama_dasawisma' => 'Anggrek 1',
             'rw' => '3', 'rt' => '2', 'nik_koordinator' => '3578010101010004',
             'nama_koordinator' => 'Lestari Ningsih', 'created_at' => $now, 'updated_at' => $now],
            ['id_kec' => 19, 'id_kel' => 103, 'periode' => 2026, 'nama_dasawisma' => 'Kenanga 1',
             'rw' => '4', 'rt' => '1', 'nik_koordinator' => '3578010101010005',
             'nama_koordinator' => 'Sri Utami', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
