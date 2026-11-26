<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailTamanBacaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatanList = DB::table('m_kecamatan')
            ->whereNull('deleted_at')
            ->orderBy('nama_kec')
            ->get();

        $rows = [];
        foreach ($kecamatanList as $i => $kec) {
            $kel = DB::table('m_kelurahan')
                ->where('kode_kec_bpjs', $kec->kode_bpjs)
                ->orderBy('nama_kel')
                ->first();

            $namaKec = strtoupper(trim($kec->nama_kec));
            $namaKel = $kel ? strtoupper(trim($kel->nama_kel)) : $namaKec;
            $isAsemrowo = str_contains($namaKec, 'ASEMROWO') || str_contains($namaKec, 'ASEM ROWO');

            $rows[] = [
                'id_kec'                   => $kec->id_kec,
                'id_kel'                   => $kel->id_kel ?? null,
                'nama_lokasi'              => $isAsemrowo ? 'TBM RW 4 ASEMROWO' : "TBM RW 01 {$namaKel}",
                'rt'                       => $isAsemrowo ? '1' : '01',
                'rw'                       => $isAsemrowo ? '4' : '01',
                'kecamatan'                => $namaKec,
                'kelurahan'                => $namaKel,
                'jml_koleksibukueksemplar' => $isAsemrowo ? '421 Eksemplar' : (250 + ($i * 15)) . ' Eksemplar',
                'created_at'               => now(),
                'updated_at'               => now(),
            ];
        }

        if (!empty($rows)) {
            DB::table('m_detail_taman_bacaan')->insert($rows);
        }
    }
}
