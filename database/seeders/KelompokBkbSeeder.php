<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KelompokBkbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/kelompok_bkb..json');

        if (! File::exists($path)) {
            $this->command->error("File tidak ditemukan: {$path}");

            return;
        }

        $data = json_decode(File::get($path), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Gagal parsing JSON: '.json_last_error_msg());

            return;
        }

        DB::table('kelompok_bkb')->truncate();

        $rows = [];

        foreach ($data as $item) {
            $rows[] = [
                'id' => $item['id'] ?? null,
                'kecamatan_id' => $item['kecamatan_id'] ?? null,
                'id_kec' => $item['id_kec'] ?? null,
                'id_kel' => $item['id_kel'] ?? null,
                'kelurahan_id' => $item['kelurahan_id'] ?? null,
                'nomor_register' => $item['nomor_register'] ?? null,
                'nama_kelompok' => $item['nama_kelompok'] ?? null,
                'alamat_jalan' => $item['alamat_jalan'] ?? null,
                'nama_pembina_pkbid' => $item['nama_pembina_pkbid'] ?? null,
                'nomor_sk' => $item['nomor_sk'] ?? null,
                'mengetahui_pembina_nama' => $item['mengetahui_pembina_nama'] ?? null,
                'mengetahui_ketua_nama' => $item['mengetahui_ketua_nama'] ?? null,
                'label' => $item['label'] ?? null,
                'nama_kel' => $item['nama_kel'] ?? null,
                'nama_kec' => $item['nama_kec'] ?? null,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('kelompok_bkb')->insert($chunk);
        }

        $this->command->info(count($rows).' data kelompok_bkb berhasil di-seed.');
    }
}
