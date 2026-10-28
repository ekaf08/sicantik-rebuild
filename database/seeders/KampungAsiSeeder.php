<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KampungAsiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kampung_asi')->delete();

        $listKec = DB::table('m_kecamatan')->get();
        $listKel = DB::table('m_kelurahan')->get();

        if ($listKec->isEmpty() || $listKel->isEmpty()) {
            $this->command->warn('Tabel master m_kecamatan atau m_kelurahan masih kosong!');
            return;
        }

        $temaKampung = [
            'SAHABAT 1', 'SAHABAT 2', 'SAHABAT 3', 'KASIH IBU', 
            'GEMOLANG', 'Kenanga Berseri', 'Anggrek Kasih', 'Mawar', 
            'HARAPAN IBU', 'Permata Bunda', 'Wijaya Sehat', 'Lestari'
        ];

        $rows = [];
        $now = Carbon::now();

        foreach ($listKec as $index => $kec) {
            $namaKec = strtoupper(trim($kec->nama_kec));
            $kelTerpilih = null;
            if (isset($listKel->first()->nama_kec)) {
                $kelTerpilih = $listKel->first(function ($item) use ($namaKec) {
                    return strtoupper(trim($item->nama_kec ?? '')) === $namaKec;
                });
            }

            if (!$kelTerpilih) {
                $kelTerpilih = $listKel[$index % $listKel->count()];
            }

            $ibuMenyusui = rand(15, 60);
            $ibuHamil    = rand(8, 30);
            $persentase  = round(rand(650, 985) / 10, 2);
            $namaTema    = $temaKampung[array_rand($temaKampung)];

            $rows[] = [
                'id_kec'           => $kec->id_kec,
                'id_kel'           => $kelTerpilih->id_kel,
                'kecamatan'        => $namaKec,
                'kelurahan'        => $kelTerpilih->nama_kel,
                'nama_kampung_asi' => "Kampung ASI {$namaTema} RW 0" . rand(1, 9),
                'jumlah_kader'     => rand(5, 15),
                'jumlah_toga'      => rand(20, 80),
                'ibu_hamil'        => $ibuHamil,
                'ibu_menyusui'     => $ibuMenyusui,
                'persentase'       => $persentase,
                'tahun'            => 2026,
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        DB::table('kampung_asi')->insert($rows);

        $this->command->info(count($rows) . ' data Kampung ASI berhasil di-generate menggunakan id_kec dan id_kel!');
    }
}