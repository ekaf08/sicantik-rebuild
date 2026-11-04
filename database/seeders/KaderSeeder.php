<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('d_kader_2026')->delete(); // hanya tabel milik sendiri

        $now = now();

        // [id_kel, nik, nama, JK, no_kk, rw, rt, jabatan, role, [jenis kader...]]
        $orang = [
            [101, '3578010101800001', 'Siti Aminah',  'P', '3578010101000001', '1', '1', 'Ketua',      'Ketua POKJA I', ['anggota_tp_pkk', 'umum', 'khusus']],
            [101, '3578010101800002', 'Rina Wati',    'P', '3578010101000002', '1', '2', 'Sekretaris', 'Sekretaris',    ['anggota_tp_pkk', 'umum']],
            [102, '3578010101800003', 'Dewi Lestari', 'P', '3578010101000003', '2', '1', 'Bendahara',  'Bendahara',     ['anggota_tp_pkk', 'khusus']],
            [102, '3578010101800004', 'Budi Santoso', 'L', '3578010101000004', '2', '3', 'Anggota',    null,            ['umum']],
            [100, '3578010101800005', 'Agus Salim',   'L', '3578010101000005', '3', '1', 'Anggota',    'Kader Posyandu', ['anggota_tp_pkk', 'umum', 'khusus']],
            [103, '3578010101800006', 'Lestari N',    'P', '3578010101000006', '4', '2', 'Anggota',    null,            ['umum']],
            [103, '3578010101800007', 'Hadi Wijaya',  'L', '3578010101000007', '4', '1', 'Anggota',    'Kader Lingkungan', ['khusus']],
        ];

        $rows = [];
        foreach ($orang as [$kel, $nik, $nama, $jk, $kk, $rw, $rt, $jabatan, $role, $jenis]) {
            foreach ($jenis as $j) {
                $rows[] = [
                    'id_kec' => 19, 'id_kel' => $kel, 'periode' => 2026,
                    'jenis_kader' => $j, 'nik' => $nik, 'nama' => $nama,
                    'jenis_kelamin' => $jk, 'no_kk' => $kk, 'rw' => $rw, 'rt' => $rt,
                    'alamat' => "Jl. Contoh RT $rt RW $rw", 'no_hp' => '08123456789',
                    'jabatan' => $jabatan, 'nama_role' => $role,
                    'created_at' => $now, 'updated_at' => $now,
                ];
            }
        }

        DB::table('d_kader_2026')->insert($rows);
    }
}
