<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pokja4MasterSeeder extends Seeder
{
    public function run(): void
    {
        $alias = [
            'kader_kesehatan', 'gizi', 'kesling', 'phbs', 'kb', 'kader_sby_hebat', // 3-8
            'posyandu', 'imunisasi', 'pkg', 'tbc',                                 // 9-12
            'jamban', 'spal', 'tempat_sampah',                                     // 13-15
            'jumlah_mck',                                                          // 16
            'pdam', 'sumur', 'lain_lain',                                          // 17-19
            'jumlah_pus', 'jumlah_wus',                                            // 20-21
            'akseptor_kb_l', 'akseptor_kb_p',                                      // 22-23
            'jml_kk_dg_tabungan', 'jml_kk_dg_asuransi_kesehatan',                  // 24-25
            'kesehatan', 'kelestarian_lh', 'perencanaan_sehat',                    // 26-28
        ];

        $now = now();

        foreach ($alias as $i => $a) {
            DB::table('m_pertanyaan_dashboard_2026')->updateOrInsert(
                ['tb_dashboard' => 'd_pokja_4_2026', 'alias' => $a],
                [
                    'nama_pertanyaan' => $a,
                    'urutan'          => $i + 3,
                    'is_disable'      => true,   // ubah ke false setelah query_detail terisi
                    'jenis_form'      => 0,
                    'query_detail'    => null,
                    'created_at'      => $now,
                ]
            );
        }
    }
}
