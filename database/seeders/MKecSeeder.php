<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class MKecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/m_kecamatan.json');

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
                'id_kec'              => $item['id_kec'],
                'nama_kec'            => $item['nama_kec'],
                'no_kab'              => $item['no_kab'],
                'no_prop'             => $item['no_prop'],
                'kode_bpjs'           => $item['kode_bpjs'],
                'id_wilayah'          => $item['id_wilayah'],
                'new_nama_kec'        => $item['new_nama_kec'],
                'id_kec_pemerintahan' => $item['id_kec_pemerintahan'],
                'id_kec_sitomas'      => $item['id_kec_sitomas'],
                'id_kec_dispusip'     => $item['id_kec_dispusip'],
                'kec_sibasam'         => $item['kec_sibasam'],
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        // Insert per-chunk supaya aman untuk data besar
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('m_kecamatan')->insert($chunk);
        }

        $this->command->info(count($rows) . ' data kecamatan berhasil di-seed.');
    }
}
