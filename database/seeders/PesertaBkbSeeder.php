<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesertaBkbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelurahanList = DB::table('m_kelurahan as kel')
            ->join('m_kecamatan as kec', 'kec.kode_bpjs', '=', 'kel.kode_kec_bpjs')
            ->whereNull('kec.deleted_at')
            ->select('kec.id_kec', 'kec.nama_kec', 'kel.id_kel', 'kel.nama_kel')
            ->orderBy('kec.nama_kec')
            ->orderBy('kel.nama_kel')
            ->get();

        $rows = [];
        foreach ($kelurahanList as $i => $wil) {
            $namaKel = strtoupper(trim($wil->nama_kel));
            $namaKec = strtoupper(trim($wil->nama_kec));
            $isAsemrowo = $namaKel === 'ASEM ROWO' || $namaKel === 'ASEMROWO';

            $rows[] = [
                'id_kec'     => $wil->id_kec,
                'id_kel'     => $wil->id_kel,
                'nik'        => $isAsemrowo ? '3525111911940001' : '3578' . str_pad((string) ($i + 100001), 12, '0', STR_PAD_LEFT),
                'nama'       => $isAsemrowo ? 'NANANG SUHARSONO' : "PESERTA BKB {$namaKel}",
                'nama_anak'  => $isAsemrowo ? 'QIARA HUMAIRA S.' : "ANAK BKB {$namaKel}",
                'kelurahan'  => $namaKel,
                'kecamatan'  => $namaKec,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($rows)) {
            foreach (array_chunk($rows, 100) as $chunk) {
                DB::table('peserta_bkb')->insert($chunk);
            }
        }
    }
}
