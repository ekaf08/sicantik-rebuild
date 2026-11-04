<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SothTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_inovasi_soth')->delete();

        $listKec = DB::table('m_kecamatan')->get();
        $listKel = DB::table('m_kelurahan')->get();

        if ($listKec->isEmpty() || $listKel->isEmpty()) {
            $this->command->warn('Tabel master m_kecamatan atau m_kelurahan masih kosong!');
            return;
        }

        $namaTemas = [
            'Bina Keluarga Balita Ceria',
            'Melati Raya',
            'Tunas Bangsa',
            'Harapan Ibu',
            'Sejahtera Bersama',
            'Tunas Mandiri',
            'Bintang Kecil',
            'Kasih Ibu',
            'Pelita Hati',
            'Anggrek Unggul',
            'Permata Bunda',
            'Maju Bersama',
            'Citra Keluarga',
            'Smart Parents',
            'Mutiara Kasih'
        ];

        $jalanTemas = [
            'Jl. Kenjeran Baru',
            'Jl. Darmo Kali',
            'Jl. Tambaksari Selatan',
            'Jl. Rungkut Madya',
            'Jl. Pandegiling',
            'Jl. Kertajaya',
            'Jl. Banyu Urip Kidul',
            'Jl. Kupang Gunung Timur',
            'Jl. Raya Sememi',
            'Jl. Gebang Wetan',
            'Jl. Asem Mulya',
            'Jl. Kedung Cowek'
        ];

        $rows = [];
        $now = Carbon::now();

        foreach ($listKec as $index => $kec) {
            $namaKec = strtoupper(trim($kec->nama_kec));
            $kelTerpilih = null;

            if (isset($listKel->first()->id_kec)) {
                $kelTerpilih = $listKel->first(function ($item) use ($kec) {
                    return (string) $item->id_kec === (string) $kec->id_kec;
                });
            }

            if (!$kelTerpilih && isset($listKel->first()->nama_kec)) {
                $kelTerpilih = $listKel->first(function ($item) use ($namaKec) {
                    return strtoupper(trim($item->nama_kec ?? '')) === $namaKec;
                });
            }

            // Fallback modulo jika tidak ada relasi langsung yang cocok
            if (!$kelTerpilih) {
                $kelTerpilih = $listKel[$index % $listKel->count()];
            }

            $namaTema  = $namaTemas[array_rand($namaTemas)];
            $namaJalan = $jalanTemas[array_rand($jalanTemas)];
            $rt        = str_pad((string) rand(1, 12), 2, '0', STR_PAD_LEFT);
            $rw        = str_pad((string) rand(1, 8), 2, '0', STR_PAD_LEFT);

            $rataPre   = round(rand(5000, 6800) / 100, 2);
            $rataPost  = round(rand(8000, 9600) / 100, 2);

            $rows[] = [
                'nama'          => "SOTH {$namaTema} RW {$rw}",
                'alamat'        => "{$namaJalan} No. " . rand(1, 120),
                'rt'            => $rt,
                'rw'            => $rw,
                'kelurahan'     => $kelTerpilih->nama_kel,
                'kecamatan'     => $namaKec,
                'rata_pre'      => $rataPre,
                'rata_post'     => $rataPost,
                'total_peserta' => rand(20, 40),
                'created_by'    => 'System',
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::table('t_inovasi_soth')->insert($rows);

        $this->command->info(count($rows) . ' data SOTH berhasil di-generate sesuai kecamatan & kelurahan!');
    }
}