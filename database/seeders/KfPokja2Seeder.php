<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KfPokja2Seeder extends Seeder
{
    public function run(): void
    {
        $idPertanyaanKlp = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_2_2026')
            ->where('alias', 'kf_klp')
            ->value('id');

        $idPertanyaanWarga = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_2_2026')
            ->where('alias', 'kf_warga')
            ->value('id');

        // Ambil salah satu kelurahan (misal Babatan / Wiyung) untuk sample data
        $kel = DB::table('m_kelurahan as l')
            ->join('m_kecamatan as k', 'k.kode_bpjs', '=', 'l.kode_kec_bpjs')
            ->select('k.id_kec', 'l.id_kel')
            ->where('l.nama_kel', 'ILIKE', '%BABATAN%')
            ->first()
            ?? DB::table('m_kelurahan as l')
                ->join('m_kecamatan as k', 'k.kode_bpjs', '=', 'l.kode_kec_bpjs')
                ->select('k.id_kec', 'l.id_kel')
                ->first();

        if (!$kel) {
            return;
        }

        // Seed Kelompok Belajar KF
        DB::table('m_kelompok_belajar_pokja2_kf')->insert([
            [
                'id_pertanyaan'      => $idPertanyaanKlp,
                'id_kec'             => $kel->id_kec,
                'id_kel'             => $kel->id_kel,
                'periode'            => 2026,
                'nama'               => 'Kelompok KF Melati',
                'alamat'             => 'Jl. Raya Babatan No. 12',
                'rt'                 => '001',
                'rw'                 => '002',
                'jenis_keterampilan' => 'Menjahit & Sulam',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id_pertanyaan'      => $idPertanyaanKlp,
                'id_kec'             => $kel->id_kec,
                'id_kel'             => $kel->id_kel,
                'periode'            => 2026,
                'nama'               => 'Kelompok KF Anggrek',
                'alamat'             => 'Jl. Babatan Indah Blok B-5',
                'rt'                 => '003',
                'rw'                 => '004',
                'jenis_keterampilan' => 'Tata Boga & Kue Basah',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);

        // Seed Warga Belajar KF
        DB::table('m_warga_belajar_pokja2_kf')->insert([
            [
                'id_pertanyaan'      => $idPertanyaanWarga,
                'id_kec'             => $kel->id_kec,
                'id_kel'             => $kel->id_kel,
                'periode'            => 2026,
                'nama'               => 'Siti Aminah',
                'alamat'             => 'Jl. Raya Babatan No. 14',
                'rt'                 => '001',
                'rw'                 => '002',
                'jenis_keterampilan' => 'Menjahit & Sulam',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id_pertanyaan'      => $idPertanyaanWarga,
                'id_kec'             => $kel->id_kec,
                'id_kel'             => $kel->id_kel,
                'periode'            => 2026,
                'nama'               => 'Rina Susanti',
                'alamat'             => 'Jl. Babatan Indah Blok B-8',
                'rt'                 => '003',
                'rw'                 => '004',
                'jenis_keterampilan' => 'Tata Boga & Kue Basah',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}