<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaderPokja1Seeder extends Seeder
{
    public function run(): void
    {
        DB::table('kader_pokja_1_2026')->truncate();

        $faker = fake('id_ID');
        $jabatanList = ['Ketua POKJA I', 'Sekretaris POKJA I', 'Anggota POKJA I'];
        $rows = [];
        $counter = 1;

        $namaRandom = function (string $jk) use ($faker): string {
            $depan = $jk === 'L' ? $faker->firstNameMale() : $faker->firstNameFemale();
            return $depan . ' ' . $faker->lastName();
        };

        // 1. Dummy Kader TP PKK KOTA (id_kec = 32, id_kel = null)
        for ($i = 1; $i <= 3; $i++) {
            $jk = $i % 2 === 0 ? 'L' : 'P';
            $rows[] = [
                'id_kec'        => 32,
                'id_kel'        => null,
                'periode'       => 2026,
                'nik'           => '357801' . str_pad($counter, 10, '0', STR_PAD_LEFT),
                'nama'          => $namaRandom($jk),
                'jenis_kelamin' => $jk,
                'no_kk'         => '35780199' . str_pad($counter, 8, '0', STR_PAD_LEFT),
                'rw'            => '01',
                'rt'            => '02',
                'alamat'        => 'Jl. Jimerto No. 25-27, Surabaya',
                'no_hp'         => '08123456' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                'jabatan'       => $jabatanList[$i - 1],
                'nama_role'     => $jabatanList[$i - 1],
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
            $counter++;
        }

        // 2. Dummy Kader TP PKK KECAMATAN (id_kel = null) untuk beberapa kecamatan
        $kecamatanList = DB::table('m_kecamatan')
            ->where('id_kec', '!=', 32)
            ->whereNull('deleted_at')
            ->limit(5)
            ->get();

        foreach ($kecamatanList as $kec) {
            for ($i = 1; $i <= 2; $i++) {
                $jk = $i % 2 === 0 ? 'L' : 'P';
                $rows[] = [
                    'id_kec'        => $kec->id_kec,
                    'id_kel'        => null,
                    'periode'       => 2026,
                    'nik'           => '357802' . str_pad($counter, 10, '0', STR_PAD_LEFT),
                    'nama'          => $namaRandom($jk),
                    'jenis_kelamin' => $jk,
                    'no_kk'         => '35780299' . str_pad($counter, 8, '0', STR_PAD_LEFT),
                    'rw'            => '0' . $i,
                    'rt'            => '01',
                    'alamat'        => 'Kantor Kecamatan ' . $kec->nama_kec,
                    'no_hp'         => '08123457' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'jabatan'       => $jabatanList[$i - 1],
                    'nama_role'     => $jabatanList[$i - 1],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
                $counter++;
            }
        }

        // 3. Dummy Kader KELURAHAN (id_kel terisi)
        $kelurahanList = DB::table('m_kelurahan as l')
            ->join('m_kecamatan as k', 'k.kode_bpjs', '=', 'l.kode_kec_bpjs')
            ->select('k.id_kec', 'l.id_kel', 'l.nama_kel')
            ->limit(15)
            ->get();

        foreach ($kelurahanList as $kel) {
            for ($i = 1; $i <= 3; $i++) {
                $jk = $i % 3 === 0 ? 'L' : 'P';
                $rows[] = [
                    'id_kec'        => $kel->id_kec,
                    'id_kel'        => $kel->id_kel,
                    'periode'       => 2026,
                    'nik'           => '357803' . str_pad($counter, 10, '0', STR_PAD_LEFT),
                    'nama'          => $namaRandom($jk),
                    'jenis_kelamin' => $jk,
                    'no_kk'         => '35780399' . str_pad($counter, 8, '0', STR_PAD_LEFT),
                    'rw'            => '0' . $i,
                    'rt'            => '0' . $i,
                    'alamat'        => 'Jl. Raya ' . $kel->nama_kel . ' No. ' . $i,
                    'no_hp'         => '08123458' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'jabatan'       => $jabatanList[$i - 1],
                    'nama_role'     => $jabatanList[$i - 1],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
                $counter++;
            }
        }

        DB::table('kader_pokja_1_2026')->insert($rows);
    }
}