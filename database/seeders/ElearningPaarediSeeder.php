<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ElearningPaarediSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('elearning_paaredi')->delete();

        $listKec = DB::table('m_kecamatan')->get();
        $listKel = DB::table('m_kelurahan')->get();

        if ($listKec->isEmpty() || $listKel->isEmpty()) {
            return;
        }

        $materiList = [
            'Pola Asuh Anak dan Remaja di Era Digital (PAAREDI)',
            'Pencegahan Kekerasan Dalam Rumah Tangga (PKDRT)',
            'Pencegahan Perkawinan Anak & Stunting Keluarga',
            'Ketahanan Keluarga & Komunikasi Efektif Orang Tua',
            'Perlindungan Anak Terpadu Berbasis Masyarakat (PATBM)'
        ];

        $namaList = [
            'Siti Aminah', 'Sri Wahyuni', 'Nurul Hidayah', 'Endang Sulastri', 'Rina Marlina',
            'Dewi Sartika', 'Tri Rahayu', 'Yuni Astuti', 'Ratna Sari', 'Lilik Suryani',
            'Anik Susilowati', 'Fitri Handayani', 'Indah Permatasari', 'Wulan Dari', 'Ningsih Rahmawati'
        ];

        $skorPreset = [91.25, 85.00, 91.74, 94.38, 90.00, 94.42, 88.50, 92.00];

        $rows = [];
        $now = Carbon::now();

        foreach ($listKec as $index => $kec) {
            $namaKec = strtoupper(trim($kec->nama_kec));
            $kelurahanDiKec = $listKel->filter(function ($item) use ($kec, $namaKec) {
                if (isset($item->id_kec)) {
                    return $item->id_kec == $kec->id_kec;
                }
                return strtoupper(trim($item->nama_kec ?? '')) === $namaKec;
            });

            if ($kelurahanDiKec->isEmpty()) {
                $kelurahanDiKec = collect([$listKel[$index % $listKel->count()]]);
            }

            foreach ($kelurahanDiKec as $kelIdx => $kel) {
                $jumlahPeserta = rand(3, 5);
                $baseSkor = $skorPreset[($index + $kelIdx) % count($skorPreset)];
                for ($i = 0; $i < $jumlahPeserta; $i++) {
                    $rows[] = [
                        'id_kec'       => $kec->id_kec,
                        'id_kel'       => $kel->id_kel,
                        'kecamatan'    => $namaKec,
                        'kelurahan'    => strtoupper(trim($kel->nama_kel)),
                        'nama_peserta' => $namaList[($index + $kelIdx + $i) % count($namaList)],
                        'nik'          => '3578' . str_pad($index + 10, 2, '0', STR_PAD_LEFT) . '450885' . rand(1000, 9999),
                        'materi'       => $materiList[($index + $i) % count($materiList)],
                        'skor'         => $baseSkor,
                        'tahun'        => 2026,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }
            }
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            DB::table('elearning_paaredi')->insert($chunk);
        }
    }
}