<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pokja2KaderSeeder extends Seeder
{
    public function run(): void
    {
        $jenisList = ['warga_buta', 'tpk3_pkk', 'damas_pkk', 'up2k_pemula', 'up2k_madya',
                      'koperasi_anggota', 'tutor_kf', 'kader_koperasi', 'kader_keterampilan',
                      'kader_bkb', 'lp3_pkk'];

        DB::table('d_kader_2026')->whereIn('jenis_kader', $jenisList)->delete();

        $now  = now();
        $rows = [];
        $n    = 0;

        foreach ($jenisList as $jenis) {
            foreach ([101, 102, 100, 103] as $kel) {
                $jumlah = ($kel % 3) + 1;          // 1 sampai 3 orang per kelurahan
                for ($i = 1; $i <= $jumlah; $i++) {
                    $n++;
                    $rows[] = [
                        'id_kec' => 19, 'id_kel' => $kel, 'periode' => 2026,
                        'jenis_kader' => $jenis,
                        'nik' => '35780101' . str_pad($n, 8, '0', STR_PAD_LEFT),
                        'nama' => 'Warga ' . $n,
                        'jenis_kelamin' => $n % 2 ? 'P' : 'L',
                        'no_kk' => '35780101' . str_pad($n + 5000, 8, '0', STR_PAD_LEFT),
                        'rw' => (string) $i, 'rt' => (string) ($i + 1),
                        'alamat' => "Jl. Contoh $n",
                        'no_hp' => '0812000' . str_pad($n, 4, '0', STR_PAD_LEFT),
                        'jabatan' => 'Anggota', 'nama_role' => 'Kader',
                        'tempat_lahir' => 'Surabaya',
                        'tanggal_lahir' => '1985-01-' . str_pad(($n % 27) + 1, 2, '0', STR_PAD_LEFT),
                        'created_at' => $now, 'updated_at' => $now,
                    ];
                }
            }
        }

        DB::table('d_kader_2026')->insert($rows);
    }
}