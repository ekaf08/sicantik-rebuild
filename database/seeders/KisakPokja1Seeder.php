<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class KisakPokja1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tentukan path file JSON
        $jsonPath = database_path('json/kisak_pokja1.json');

        // Cek apakah file ada
        if (!File::exists($jsonPath)) {
            $this->command->error("File JSON tidak ditemukan di: {$jsonPath}");
            return;
        }

        // Baca dan decode file JSON
        $json = File::get($jsonPath);
        $data = json_decode($json, true);

        // Kosongkan tabel sebelum diisi (Opsional, agar tidak duplikat jika dijalankan ulang)
        DB::table('kisak_pokja1')->truncate();

        $chunkSize = 500; // Insert per 500 baris agar tidak memory leak
        $chunks = array_chunk($data, $chunkSize);

        foreach ($chunks as $chunk) {
            $insertData = [];

            foreach ($chunk as $item) {
                $insertData[] = [
                    'id'            => $item['id'],
                    'tgl_kegiatan'  => $item['tgl_kegiatan'] ? Carbon::createFromFormat('d/m/Y', $item['tgl_kegiatan'])->format('Y-m-d') : null,
                    'tempat'        => $item['tempat'],
                    'materi'        => $item['materi'],
                    'id_kec'        => $item['id_kec'],
                    'id_kel'        => $item['id_kel'],
                    // Konversi format created_at dari "d/m/Y H:i:s" ke "Y-m-d H:i:s"
                    'created_at'    => $item['created_at'] ? Carbon::createFromFormat('d/m/Y H:i:s', $item['created_at'])->format('Y-m-d H:i:s') : now(),
                    'updated_at'    => $item['updated_at'] ? Carbon::createFromFormat('d/m/Y H:i:s', $item['updated_at'])->format('Y-m-d H:i:s') : now(),
                    'deleted_at'    => $item['deleted_at'] ? Carbon::createFromFormat('d/m/Y H:i:s', $item['deleted_at'])->format('Y-m-d H:i:s') : null,
                    'pertanyaan_id' => $item['pertanyaan_id'],
                    'nama_kec'      => $item['nama_kec'],
                    'nama_kel'      => $item['nama_kel'],
                ];
            }

            // Insert chunk ke database
            DB::table('kisak_pokja1')->insert($insertData);
        }

        $this->command->info("Berhasil mengimpor " . count($data) . " data ke tabel kisak_pokja1.");
    }
}
