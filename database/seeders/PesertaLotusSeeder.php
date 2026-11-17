<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesertaLotusSeeder extends Seeder
{
    public function run(): void
    {
        // hanya menghapus data tes buatan kita
        DB::table('peserta_lotus')->where('nama_pendamping', 'like', 'TES-%')->delete();

        $kecNama = DB::table('m_kecamatan')->where('id_kec', 19)->value('nama_kec');
        $kelNama = DB::table('m_kelurahan')->whereIn('id_kel', [100, 101, 102, 103])->pluck('nama_kel', 'id_kel');

        // flag_kolom => id di m_pertanyaan_dashboard_2026
        $pertanyaanMap = [
            'kisah'  => 59,
            'krisan' => 63,
            'kilas'  => 67,
            'kiat'   => 71,
            'pkbn'   => 79,
        ];

        $now  = now();
        $rows = [];
        $n    = 0;

        foreach ($pertanyaanMap as $g => $pertanyaanId) {
            foreach ([101, 102, 100, 103] as $kel) {
                $jumlah = ($kel % 3) + 1;
                for ($i = 1; $i <= $jumlah; $i++) {
                    $n++;
                    $rows[] = [
                        'pertanyaan_id'   => $pertanyaanId,
                        'flag_kolom'      => $g,
                        'no_kk'           => '35780101' . str_pad($n + 6000, 8, '0', STR_PAD_LEFT),
                        'nik'             => '35780101' . str_pad($n + 9000, 8, '0', STR_PAD_LEFT),
                        'nama'            => "Peserta $n",
                        'nik_pendamping'  => '35780101' . str_pad($n + 500, 8, '0', STR_PAD_LEFT),
                        'nama_pendamping' => "TES-Pendamping $n",
                        'pendamping'      => 'Kader',
                        'alamat'          => "Jl. Contoh $n",
                        'id_kec'          => 19, 'id_kel' => $kel,
                        'nama_kec'        => $kecNama, 'nama_kel' => $kelNama[$kel] ?? null,
                        'rw'              => (string) $i, 'rt' => '1',
                        'tahun'           => 2026, 'tahap' => 'Tahap ' . (($n % 3) + 1),
                        'created_at'      => $now, 'updated_at' => $now,
                    ];
                }
            }
        }

        DB::table('peserta_lotus')->insert($rows);
    }
}