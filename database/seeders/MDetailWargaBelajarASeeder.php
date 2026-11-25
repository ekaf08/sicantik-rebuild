<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MDetailWargaBelajarASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/m_detail_warga_belajar_a.json');

        if (! File::exists($path)) {
            $this->command->error("File tidak ditemukan: {$path}");

            return;
        }

        $data = json_decode(File::get($path), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Gagal parsing JSON: '.json_last_error_msg());

            return;
        }

        DB::table('m_detail_warga_belajar_a')->truncate();

        $rows = [];

        foreach ($data as $item) {
            $rows[] = [
                'id_kel' => $item['id_kel'] ?? null,
                'kel' => $item['kel'] ?? null,
                'id_kec' => $item['id_kec'] ?? null,
                'lembaga' => $item['lembaga'] ?? null,
                'id_kelompok' => $item['id_kelompok'] ?? null,
                'nama' => $item['nama'] ?? null,
                'tgl_lahir' => $item['tgl_lahir'] ?? null,
                'jenis_kelamin' => $item['jenis_kelamin'] ?? null,
                'nik' => $item['nik'] ?? null,
                'no_kk' => $item['no_kk'] ?? null,
                'alamat' => $item['alamat'] ?? null,
                'rt' => $item['rt'] ?? null,
                'rw' => $item['rw'] ?? null,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('m_detail_warga_belajar_a')->insert($chunk);
        }

        $this->command->info(count($rows).' data m_detail_warga_belajar_a berhasil di-seed.');
    }
}
