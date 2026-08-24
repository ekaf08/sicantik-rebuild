<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'role_id'    => 1,
                'username'   => 'kominfo',
                'name'       => 'Admin Kota',
                'email'      => 'admin.kota@sicantik.surabaya.go.id',
                'password'   => Hash::make('password123'),
                'keterangan' => 'Administrator Kota Surabaya',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id'    => 2,
                'username'   => 'admin_kecamatan',
                'name'       => 'Admin Kecamatan',
                'email'      => 'admin.kecamatan@sicantik.surabaya.go.id',
                'password'   => Hash::make('password123'),
                'keterangan' => 'Administrator Kecamatan',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id'    => 3,
                'name'       => 'Admin Kelurahan',
                'username'   => 'admin_kelurahan',
                'email'      => 'admin.kelurahan@sicantik.surabaya.go.id',
                'password'   => Hash::make('password123'),
                'keterangan' => 'Administrator Kelurahan',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id'    => 4,
                'name'       => 'Ketua PKK',
                'username'   => 'ketua_pkk',
                'email'      => 'ketua.pkk@sicantik.surabaya.go.id',
                'password'   => Hash::make('password123'),
                'keterangan' => 'Ketua Tim Penggerak PKK',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id'    => 5,
                'name'       => 'Anggota PKK',
                'username'   => 'anggota_pkk',
                'email'      => 'anggota.pkk@sicantik.surabaya.go.id',
                'password'   => Hash::make('password123'),
                'keterangan' => 'Anggota Tim Penggerak PKK',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            // Cek dulu apakah email sudah terdaftar, kalau sudah lewati (tidak insert ulang)
            $exists = DB::table('users')->where('email', $user['email'])->exists();

            if (!$exists) {
                DB::table('users')->insert($user);

                $this->command->info("User '{$user['name']}' berhasil di-insert.");
            } else {
                $this->command->warn("User dengan email '{$user['email']}' sudah ada, dilewati.");
            }
        }
    }
}
