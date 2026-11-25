<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MDetailKelompokBelajarCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/m_detail_kelompok_belajar_c.json');

        if (! File::exists($path)) {
            $this->command->error("File tidak ditemukan: {$path}");

            return;
        }

        $data = json_decode(File::get($path), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Gagal parsing JSON: '.json_last_error_msg());

            return;
        }

        DB::table('m_detail_kelompok_belajar_c')->truncate();

        $rows = [];

        foreach ($data as $item) {
            $rows[] = [
                'id_kelompok' => $item['id_kelompok'] ?? null,
                'lembaga' => $item['lembaga'] ?? null,
                'id_kel' => $item['id_kel'] ?? null,
                'kel' => $item['kel'] ?? null,
                'id_kec' => $item['id_kec'] ?? null,
                'alamat' => $item['alamat'] ?? null,
                'rt_rw' => $item['rt_rw'] ?? null,
                'nama_petugas' => $item['nama_petugas'] ?? null,
                'nik_petugas' => $item['nik_petugas'] ?? null,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('m_detail_kelompok_belajar_c')->insert($chunk);
        }

        $this->command->info(count($rows).' data m_detail_kelompok_belajar_c berhasil di-seed.');
    }
}
