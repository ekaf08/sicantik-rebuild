<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SicantikSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id'          => 1,
                'judul'       => 'SISTEM INFORMASI PENCATATAN KEGIATAN DAN INOVASI PKK KOTA SURABAYA',
                'deskripsi'   => 'SiCantik adalah platform digital yang mendukung transparansi, pendataan, dan publikasi kegiatan PKK di Kota Surabaya.',
                'gambar'      => '/public/uploads/sicantik-1.jpg',
                'keterangan'  => 'Sekretariat PKK Kota Surabaya',
                'created_by'  => 'Admin PKK Kota Surabaya',
                'updated_by'  => null,
                'deleted_by'  => null,
            ],
            [
                'id'          => 2,
                'judul'       => 'Pos PAUD Terpadu',
                'deskripsi'   => 'Visualisasi sebaran risiko stunting balita berbasis geolokasi kelurahan untuk memudahkan intervensi gizi terpadu TP PKK bersama Puskesmas.',
                'gambar'      => '/public/uploads/sicantik-2.jpg',
                'keterangan'  => 'Pokja IV & Sekretariat',
                'created_by'  => 'Admin PKK Kota Surabaya',
                'updated_by'  => null,
                'deleted_by'  => null,
            ],
            [
                'id'          => 3,
                'judul'       => 'LAPORAN SEKOLAH LANSIA TANGGUH (SELANTANG)',
                'deskripsi'   => 'LAPORAN SEKOLAH LANSIA TANGGUH (SELANTANG) TAHUN 2025',
                'gambar'      => '/public/uploads/sicantik-3.jpg',
                'keterangan'  => '-',
                'created_by'  => 'Pokja II',
                'updated_by'  => null,
                'deleted_by'  => null,
            ],
            [
                'id'          => 4,
                'judul'       => 'LAPORAN SEKOLAH ORANG TUA HEBAT (SOTH)',
                'deskripsi'   => 'LAPORAN SEKOLAH ORANG TUA HEBAT (SOTH) TAHUN 2025',
                'gambar'      => '/public/uploads/sicantik-4.jpg',
                'keterangan'  => '-',
                'created_by'  => 'Admin PKK Kota Surabaya',
                'updated_by'  => null,
                'deleted_by'  => null,
            ],
            [
                'id'          => 5,
                'judul'       => 'Katalog Produk UP2K PKK Berbasis Web',
                'deskripsi'   => 'Program pemasaran digital UMKM binaan kader PKK kelurahan untuk memperluas jangkauan promosi produk olahan pangan dan kerajinan lokal.',
                'gambar'      => '/public/uploads/sicantik-5.jpg',
                'keterangan'  => 'Pemberdayaan Ekonomi',
                'created_by'  => 'Admin PKK Kota Surabaya',
                'updated_by'  => null,
                'deleted_by'  => null,
            ],
        ];

        DB::table('inovasi_sicantik')->upsert($data, ['id'], [
            'judul', 'deskripsi', 'gambar', 'keterangan', 'created_by', 'updated_by', 'deleted_by'
        ]);
    }
}