<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class MKelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('json/m_kelurahan.json');

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
                'id_kel'              => $item['id_kel'],
                'nama_kel'            => $item['nama_kel'],
                'no_kab'              => $item['no_kab'],
                'no_prop'             => $item['no_prop'],
                'no_kec'              => $item['no_kec'],
                'kode_kec_bpjs'       => $item['kode_kec_bpjs'],
                'kode_kel_bpjs'       => $item['kode_kel_bpjs'],
                'kodepos'             => $item['kodepos'],
                'kode_faskes'         => $item['kode_faskes'],
                'no_puskesmas'        => $item['no_puskesmas'],
                'nama_puskesmas'      => $item['nama_puskesmas'],
                'new_nama_kel'        => $item['new_nama_kel'],
                'nama_kel_nas'        => $item['nama_kel_nas'],
                'id_kel_pemerintahan' => $item['id_kel_pemerintahan'],
                'id_kel_sitomas'      => $item['id_kel_sitomas'],
                'id_kel_dispusip'     => $item['id_kel_dispusip'],
                'kel_sibasam'         => $item['kel_sibasam'],
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('m_kelurahan')->insert($chunk);
        }

        $this->command->info(count($rows) . ' data kelurahan berhasil di-seed.');
    }
}
