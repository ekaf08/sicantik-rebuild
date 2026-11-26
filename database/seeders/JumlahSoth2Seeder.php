<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class JumlahSoth2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/jumlah_soth_2.json');
        
        if (! File::exists($path)) {
            $this->command->error("File tidak ditemukan: {$path}");

            return;
        }

        $data = json_decode(File::get($path), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Gagal parsing JSON: '.json_last_error_msg());

            return;
        }

        DB::table('jumlah_soth_2')->truncate();

        $rows = [];

        foreach ($data as $item) {
            $rows[] = [
                'nama_soth'   => $item['nama_soth'] ?? null,
                'alamat_soth' => $item['alamat_soth'] ?? null,
                'rt_soth'     => $item['rt_soth'] ?? null,
                'rw_soth'     => $item['rw_soth'] ?? null,
                'id_kel'      => $item['id_kel'] ?? null,
                'nama_kel'    => $item['nama_kel'] ?? null,
                'id_kec'      => $item['id_kec'] ?? null,
                'nama_kec'    => $item['nama_kec'] ?? null,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('jumlah_soth_2')->insert($chunk);
        }

        $this->command->info(count($rows).' data jumlah_soth_2 berhasil di-seed.');
    }
}
