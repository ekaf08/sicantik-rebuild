<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SurabayaEmasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $wilayahList = [
            ['kecamatan' => 'GENTENG', 'kelurahan' => 'EMBONG KALIASIN'],
            ['kecamatan' => 'GENTENG', 'kelurahan' => 'KETABANG'],
            ['kecamatan' => 'GENTENG', 'kelurahan' => 'KAPASARI'],
            ['kecamatan' => 'GENTENG', 'kelurahan' => 'PENELEH'],
            ['kecamatan' => 'TEGALSARI', 'kelurahan' => 'KEDUNGDORO'],
            ['kecamatan' => 'TEGALSARI', 'kelurahan' => 'TEGALSARI'],
            ['kecamatan' => 'TEGALSARI', 'kelurahan' => 'WONOREJO'],
            ['kecamatan' => 'TEGALSARI', 'kelurahan' => 'DR. SOETOMO'],
            ['kecamatan' => 'GUBENG', 'kelurahan' => 'AIRLANGGA'],
            ['kecamatan' => 'GUBENG', 'kelurahan' => 'GUBENG'],
            ['kecamatan' => 'GUBENG', 'kelurahan' => 'KERTAJAYA'],
            ['kecamatan' => 'GUBENG', 'kelurahan' => 'MOJO'],
            ['kecamatan' => 'RUNGKUT', 'kelurahan' => 'KALIRUNGKUT'],
            ['kecamatan' => 'RUNGKUT', 'kelurahan' => 'RUNGKUT KIDUL'],
            ['kecamatan' => 'RUNGKUT', 'kelurahan' => 'MEDOKAN AYU'],
            ['kecamatan' => 'RUNGKUT', 'kelurahan' => 'PENJARINGANSARI'],
            ['kecamatan' => 'WONOKROMO', 'kelurahan' => 'DARMO'],
            ['kecamatan' => 'WONOKROMO', 'kelurahan' => 'SAWUGGILING'],
            ['kecamatan' => 'WONOKROMO', 'kelurahan' => 'WONOKROMO'],
            ['kecamatan' => 'WONOKROMO', 'kelurahan' => 'JAGIR'],
            ['kecamatan' => 'BUBUTAN', 'kelurahan' => 'ALUN-ALUN CONTOMP'],
            ['kecamatan' => 'BUBUTAN', 'kelurahan' => 'BUBUTAN'],
            ['kecamatan' => 'BUBUTAN', 'kelurahan' => 'GUNDIH'],
            ['kecamatan' => 'BUBUTAN', 'kelurahan' => 'JEPARA'],
            ['kecamatan' => 'TAMBAKSARI', 'kelurahan' => 'DUKUH SETRO'],
            ['kecamatan' => 'TAMBAKSARI', 'kelurahan' => 'GADING'],
            ['kecamatan' => 'TAMBAKSARI', 'kelurahan' => 'PACARKELING'],
            ['kecamatan' => 'TAMBAKSARI', 'kelurahan' => 'PLOSO'],
            ['kecamatan' => 'KENJERAN', 'kelurahan' => 'BULAK BANTENG'],
            ['kecamatan' => 'KENJERAN', 'kelurahan' => 'TAMBAK WEDI'],
            ['kecamatan' => 'KENJERAN', 'kelurahan' => 'TANAH KALI KEDINDING'],
            ['kecamatan' => 'KENJERAN', 'kelurahan' => 'SIDOTOPO WETAN'],
        ];

        $namaDepanL = ['Ahmad', 'Rizky', 'Bima', 'Kenzo', 'Rafi', 'Arka', 'Fathir', 'Muhammad', 'Rayhan', 'Gibran'];
        $namaBelakangL = ['Fauzi', 'Pratama', 'Arya', 'Daniswara', 'Alamsyah', 'Malik', 'Zayan', 'Saputra', 'Hidayat'];

        $namaDepanP = ['Aisyah', 'Nayra', 'Zahra', 'Cinta', 'Dhiya', 'Nabila', 'Khadijah', 'Aqila', 'Almira', 'Syifa'];
        $namaBelakangP = ['Putri', 'Salsabila', 'Kirana', 'Laura', 'Syakira', 'Zahra', 'Althaf', 'Anindya', 'Azzahra'];

        $statusGiziList = ['Gizi Baik', 'Beresiko Stunting', 'Gizi Kurang', 'Stunting'];

        $totalBalita = 20;
        $riwayatRows = [];
        $insertedBalitaCount = 0;

        for ($i = 1; $i <= $totalBalita; $i++) {
            $w = $wilayahList[array_rand($wilayahList)];
            $jk = ($i % 2 === 0) ? 'P' : 'L';

            $nama = ($jk === 'L')
                ? $namaDepanL[array_rand($namaDepanL)] . ' ' . $namaBelakangL[array_rand($namaBelakangL)]
                : $namaDepanP[array_rand($namaDepanP)] . ' ' . $namaBelakangP[array_rand($namaBelakangP)];

            $tglLahir = Carbon::now()->subMonths(rand(12, 36))->subDays(rand(1, 28));

            $balitaId = DB::table('surabaya_emas_balita')->insertGetId([
                'nik'                => '3578' . str_pad($i, 12, '0', STR_PAD_LEFT),
                'nama_balita'        => $nama,
                'tanggal_lahir'      => $tglLahir->format('Y-m-d'),
                'jenis_kelamin'      => $jk,
                'alamat_domisili'    => 'Jl. Contoh Warga No. ' . rand(1, 100) . ' RT ' . rand(1, 5) . ' RW ' . rand(1, 5),
                'kelurahan_domisili' => $w['kelurahan'],
                'kecamatan_domisili' => $w['kecamatan'],
                'tpk'                => 'TPK ' . $w['kelurahan'] . ' Tim ' . rand(1, 3),
                'tahun'              => 2026,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);

            $insertedBalitaCount++;

            $jumlahTimbang = rand(5, 8);
            $bbAwal = rand(75, 95) / 10;
            $tbAwal = rand(700, 750) / 10;

            for ($j = 0; $j < $jumlahTimbang; $j++) {
                $tglTimbang = (clone $tglLahir)->addMonths($j + 1);

                $riwayatRows[] = [
                    'balita_id'       => $balitaId,
                    'tanggal_timbang' => $tglTimbang->format('Y-m-d'),
                    'tinggi_badan'    => round($tbAwal + ($j * 1.4) + (rand(-3, 3) / 10), 2),
                    'berat_badan'     => round($bbAwal + ($j * 0.4) + (rand(-2, 2) / 10), 2),
                    'lila'            => round(12.0 + ($j * 0.1), 2),
                    'tbu'             => 'Normal',
                    'bbu'             => 'Normal',
                    'bbtb'            => 'Gizi Baik',
                    'status_gizi'     => $statusGiziList[array_rand($statusGiziList)],
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }
        }

        foreach (array_chunk($riwayatRows, 100) as $chunk) {
            DB::table('surabaya_emas_riwayat_timbang')->insert($chunk);
        }

        $this->command->info("{$insertedBalitaCount} data balita berhasil diisi.");
        $this->command->info(count($riwayatRows) . " data riwayat timbang berhasil diisi.");
    }
}