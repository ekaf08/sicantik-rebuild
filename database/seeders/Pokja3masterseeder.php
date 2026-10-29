<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pokja3MasterSeeder extends Seeder
{
    public function run(): void
    {
        $alias = [
            'kader_pangan', 'kader_sandang', 'kader_tata_laksana_rt', 'makanan_beras', 'makanan_non_beras',                                     'peternakan', 'perikanan', 'warung_hidup', 'lumbung_hidup',                'toga', 'tanaman_keras', 'tanaman_lainnya',                    
            'industri_pangan', 'industri_sandang', 'industri_jasa',        
            'rumah_sehat_layak', 'rumah_tidak_sehat_layak',                
        ];

        $now = now();

        foreach ($alias as $i => $a) {
            DB::table('m_pertanyaan_dashboard_2026')->updateOrInsert(
                ['tb_dashboard' => 'd_pokja_3_2026', 'alias' => $a],
                [
                    'nama_pertanyaan' => $a,
                    'urutan'          => $i + 3,   
                    'is_disable'      => true,     
                    'jenis_form'      => 0,
                    'query_detail'    => null,
                    'created_at'      => $now,
                ]
            );
        }
    }
}