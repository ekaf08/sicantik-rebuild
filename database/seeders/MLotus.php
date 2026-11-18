<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class MLotus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/m_lotus.json');

        if (!File::exists($path)) {
            $this->command->error("File tidak ditemukan: {$path}");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Gagal parsing JSON: ' . json_last_error_msg());
            return;
        }

        $now = Carbon::now();
        $rows = [];

        foreach ($data as $item) {
            $rows[] = [
                'id'              => $item['id'],
                'pertanyaan_id'            => $item['pertanyaan_id'],
                'name'              => $item['name'],
                'nama_kec'             => $item['nama_kec'],
                'nama_kel'           => $item['nama_kel'],
                'tahap'          => $item['tahap'],
                'id_kec'        => $item['id_kec'],
                'id_kel' => $item['id_kel'],
                'rw'      => $item['rw'],
                'rt'     => $item['rt'],
                'alamat'         => $item['alamat'],
                'flag_kolom'         => $item['flag_kolom'],
                'tahun'         => $item['tahun'],
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        // Insert per-chunk supaya aman untuk data besar
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('m_lotus')->insert($chunk);
        }

        $this->command->info(count($rows) . ' data m lotus berhasil di-seed.');
    }
}
