<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/user_pkk.json');

        if (!File::exists($path)) {
            $this->command->error("File tidak ditemukan: {$path}");
            return;
        }

        $json = File::get($path);
        $users = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Gagal parsing JSON: ' . json_last_error_msg());
            return;
        }

        $now = Carbon::now();

        foreach ($users as $user) {
            // Cek duplikat berdasarkan username (email tidak tersedia di JSON)
            $exists = DB::table('users')->where('username', $user['username'])->exists();

            if ($exists) {
                $this->command->warn("User dengan username '{$user['username']}' sudah ada, dilewati.");
                continue;
            }

            DB::table('users')->insert([
                'role_id'           => $user['role_id'],
                'username'          => $user['username'],
                'name'              => $user['name'],
                'id_kec'            => $user['id_kec'] ?? null,
                'id_kel'            => $user['id_kel'] ?? null,
                'email'             => $user['username'] . '@example.com', // generate sementara, sesuaikan
                'password'          => $user['password'], // sudah bcrypt hash, jangan di-hash ulang
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            $this->command->info("User '{$user['name']}' berhasil di-insert.");
        }
    }
}
