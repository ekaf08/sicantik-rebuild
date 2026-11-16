<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pokja2LainSeeder extends Seeder
{
    public function run(): void
    {
        // hanya tabel milik sendiri
        DB::table('d_warga_belajar_2026')->delete();
        DB::table('d_kelompok_belajar_2026')->delete();
        DB::table('d_paud_2026')->delete();
        DB::table('d_taman_bacaan_2026')->delete();

        $now = now();
        $w = ['id_kec' => 19, 'periode' => 2026, 'created_at' => $now, 'updated_at' => $now];

        // Taman bacaan: [kel, nama, koleksi]
        foreach ([[101, 'TBM Ilmu', 120], [101, 'Pojok Baca RW 7', 60],
                  [102, 'TBM Pelita', 90], [100, 'Rumah Baca Sememi', 45]] as [$kel, $nama, $kol]) {
            DB::table('d_taman_bacaan_2026')->insert($w + [
                'id_kel' => $kel, 'nama_lokasi' => $nama, 'rt' => '1', 'rw' => '2', 'jml_koleksi' => $kol]);
        }

        // PAUD: satu baris per tutor. [kel, npsn, lembaga, jenjang, kepala, [tutor...]]
        $paud = [
            [101, '69000001', 'PAUD Ceria',   'TK', 'Bu Ratna', ['Bu Ani', 'Bu Budi']],
            [102, '69000002', 'KB Bunga',     'KB', 'Bu Sari',  ['Bu Citra']],
            [100, '69000003', 'TK Pelangi',   'TK', 'Bu Wulan', ['Bu Dewi', 'Bu Eka']],
            [103, '69000004', 'PAUD Mentari', 'KB', 'Bu Yuni',  ['Bu Fitri']],
        ];
        foreach ($paud as [$kel, $npsn, $lem, $jen, $kepala, $tutor]) {
            foreach ($tutor as $t) {
                DB::table('d_paud_2026')->insert($w + [
                    'id_kel' => $kel, 'npsn' => $npsn, 'nama_lembaga' => $lem, 'jenjang' => $jen,
                    'kepala_lembaga' => $kepala, 'alamat' => "Jl. $lem", 'rt' => '1', 'rw' => '3',
                    'telepon' => '0311234567', 'nama_pegawai' => $t, 'jabatan' => 'Guru']);
            }
        }

        // Kelompok belajar: [kel, paket, nama, keterampilan]
        $kelompok = [
            [101, 'A',  'PKBM Melati',  null],
            [101, 'B',  'PKBM Mawar',   null],
            [102, 'C',  'PKBM Anggrek', null],
            [102, 'KF', 'LKP Kenanga',  'Menjahit'],
            [100, 'A',  'PKBM Sememi',  null],
            [103, 'KF', 'LKP Dahlia',   'Tata Boga'],
        ];
        $n = 0;
        foreach ($kelompok as [$kel, $paket, $nama, $ket]) {
            $idK = DB::table('d_kelompok_belajar_2026')->insertGetId($w + [
                'id_kel' => $kel, 'jenis_paket' => $paket, 'nama_lembaga' => $nama,
                'alamat' => "Jl. $nama", 'rt' => '1', 'rw' => '2', 'jenis_keterampilan' => $ket]);

            // 2 warga per kelompok
            for ($i = 1; $i <= 2; $i++) {
                $n++;
                DB::table('d_warga_belajar_2026')->insert($w + [
                    'id_kel' => $kel, 'id_kelompok' => $idK, 'jenis_paket' => $paket,
                    'nama' => "Warga Belajar $n", 'tgl_lahir' => '1990-05-' . str_pad($n + 1, 2, '0', STR_PAD_LEFT),
                    'jenis_kelamin' => $n % 2 ? 'P' : 'L',
                    'nik' => '35780101' . str_pad($n + 7000, 8, '0', STR_PAD_LEFT),
                    'no_kk' => '35780101' . str_pad($n + 8000, 8, '0', STR_PAD_LEFT),
                    'alamat' => "Jl. Contoh $n", 'rt' => '1', 'rw' => '2', 'jenis_keterampilan' => $ket]);
            }
        }
    }
}