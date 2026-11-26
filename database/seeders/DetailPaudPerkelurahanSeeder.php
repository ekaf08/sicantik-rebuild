<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPaudPerkelurahanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil relasi kelurahan & kecamatan yang sudah ada di database
        $wilayah = DB::table('m_kelurahan as kel')
            ->join('m_kecamatan as kec', 'kec.kode_bpjs', '=', 'kel.kode_kec_bpjs')
            ->select('kec.id_kec', 'kel.id_kel', 'kel.nama_kel')
            ->get()
            ->keyBy(fn ($item) => strtoupper(trim($item->nama_kel)));

        $contohData = [
            [
                'kelurahan' => 'ASEM ROWO',
                'nama'      => 'TPA CITRA KUSUMA',
                'jenjang'   => 'TPA',
                'alamat'    => 'JL. SEKOLAHAN NO. 15',
                'rt'        => '1',
                'rw'        => '2',
            ],
            [
                'kelurahan' => 'ASEM ROWO',
                'nama'      => 'KB TUNAS HARAPAN',
                'jenjang'   => 'KB',
                'alamat'    => 'JL. ASEM RAYA NO. 24',
                'rt'        => '3',
                'rw'        => '1',
            ],
            [
                'kelurahan' => 'GENTING KALIANAK',
                'nama'      => 'SPS MELATI PUTIH',
                'jenjang'   => 'SPS',
                'alamat'    => 'JL. KALIANAK BARAT NO. 10',
                'rt'        => '2',
                'rw'        => '4',
            ],
            [
                'kelurahan' => 'TAMBAK SARIOSO',
                'nama'      => 'TK PERTIWI JAYA',
                'jenjang'   => 'TK',
                'alamat'    => 'JL. TAMBAK SARIOSO NO. 8',
                'rt'        => '5',
                'rw'        => '3',
            ],
        ];

        $rows = [];
        foreach ($contohData as $item) {
            $kunci = strtoupper(trim($item['kelurahan']));
            // Fallback ke kelurahan pertama di DB jika nama kelurahan belum ketemu
            $infoWilayah = $wilayah->get($kunci) ?? $wilayah->first();

            if (!$infoWilayah) {
                continue;
            }

            $rows[] = [
                'id_kec'     => $infoWilayah->id_kec,
                'id_kel'     => $infoWilayah->id_kel,
                'kelurahan'  => $infoWilayah->nama_kel,
                'nama'       => $item['nama'],
                'jenjang'    => $item['jenjang'],
                'alamat'     => $item['alamat'],
                'rt'         => $item['rt'],
                'rw'         => $item['rw'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($rows)) {
            DB::table('m_detail_paud_perkelurahan')->insert($rows);
        }
    }
}
