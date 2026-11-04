<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendudukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('d_penduduk_2026')->delete(); // hanya tabel milik sendiri

        $now = now();

        // [id_kel, no_kk, rw, rt, [[nik, nama, JK, kepala?], ...]]
        $keluarga = [
            [101, '3578010101000001', '1', '1', [
                ['3578010101800001', 'Budi Santoso', 'L', true],
                ['3578010101800002', 'Siti Aminah',  'P', false],
                ['3578010101900001', 'Andi Santoso', 'L', false],
            ]],
            [101, '3578010101000002', '1', '2', [
                ['3578010101800003', 'Joko Susilo', 'L', true],
                ['3578010101800004', 'Rina Wati',   'P', false],
            ]],
            [102, '3578010101000003', '2', '1', [
                ['3578010101800005', 'Agus Salim',    'L', true],
                ['3578010101800006', 'Dewi Lestari',  'P', false],
                ['3578010101900002', 'Putri Lestari', 'P', false],
            ]],
            [100, '3578010101000004', '3', '1', [
                ['3578010101800007', 'Hadi Wijaya', 'L', true],
                ['3578010101800008', 'Lestari N',   'P', false],
            ]],
            [103, '3578010101000005', '4', '2', [
                ['3578010101800009', 'Slamet Riyadi', 'L', true],
                ['3578010101800010', 'Sri Utami',     'P', false],
            ]],
        ];

        $rows = [];
        foreach ($keluarga as [$kel, $kk, $rw, $rt, $anggota]) {
            foreach ($anggota as [$nik, $nama, $jk, $kepala]) {
                $rows[] = [
                    'id_kec' => 19, 'id_kel' => $kel, 'periode' => 2026,
                    'no_kk' => $kk, 'nik' => $nik, 'nama' => $nama,
                    'jenis_kelamin' => $jk, 'kepala_keluarga' => $kepala,
                    'rw' => $rw, 'rt' => $rt,
                    'alamat' => "Jl. Contoh RT $rt RW $rw",
                    'created_at' => $now, 'updated_at' => $now,
                ];
            }
        }

        DB::table('d_penduduk_2026')->insert($rows);
    }
}