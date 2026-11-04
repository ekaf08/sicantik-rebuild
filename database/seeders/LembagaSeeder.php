<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LembagaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('d_lembaga_2026')->delete(); // hanya tabel milik sendiri

        $now = now();
        $base = ['id_kec' => 19, 'periode' => 2026, 'jenis' => 'rw',
                 'masa_jabatan' => '2023 - 2027', 'created_at' => $now, 'updated_at' => $now];

        DB::table('d_lembaga_2026')->insert([
            $base + ['id_kel' => 101, 'rw' => '7', 'nama_ketua' => 'Suprasetyo', 'jenis_kelamin' => 'L',
                     'alamat' => 'Tengger Kandangan 7/63', 'telepon' => '08155241722'],
            $base + ['id_kel' => 101, 'rw' => '8', 'nama_ketua' => 'Hartini', 'jenis_kelamin' => 'P',
                     'alamat' => 'Kandangan 8/12', 'telepon' => '08123456701'],
            $base + ['id_kel' => 102, 'rw' => '1', 'nama_ketua' => 'Slamet', 'jenis_kelamin' => 'L',
                     'alamat' => 'Romokalisari 1/5', 'telepon' => '08123456702'],
            $base + ['id_kel' => 100, 'rw' => '2', 'nama_ketua' => 'Sumarni', 'jenis_kelamin' => 'P',
                     'alamat' => 'Sememi 2/9', 'telepon' => '08123456703'],
            $base + ['id_kel' => 103, 'rw' => '3', 'nama_ketua' => 'Prayitno', 'jenis_kelamin' => 'L',
                     'alamat' => 'Tambak Oso 3/4', 'telepon' => '08123456704'],
        ]);
    }
}