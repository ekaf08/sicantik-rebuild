<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * DATA DUMMY Kemangi (Remaja dan Orang Tua).
 * Semua baris dummy ditandai tanggal dibuat 2000-01-01 00:00:00, jadi mudah dikenali
 * dan dihapus tanpa menyentuh data asli. Dijalankan berulang kali tidak menggandakan data.
 *
 * Jalankan : php artisan db:seed --class=KemangiDummySeeder
 * Hapus    : php artisan tinker, lalu jalankan baris penghapusan dari catatan Claude.
 */
class KemangiDummySeeder extends Seeder
{
    private const PENANDA = '2000-01-01 00:00:00';

    public function run(): void
    {
        if (!Schema::hasTable('kemangi')) {
            $this->command?->error('Tabel kemangi belum ada. Jalankan migrasinya dulu.');
            return;
        }

        mt_srand(20261028);

        // Bersihkan dummy lama (hanya yang bertanda)
        DB::table('kemangi')->where('created_at', self::PENANDA)->delete();

        $wilayah = $this->ambilWilayah();
        $baris = [];

        foreach ($wilayah as $kec => $daftarKel) {
            // 2 kelurahan per kecamatan (atau 1 kalau hanya ada satu)
            $pilihan = array_slice($daftarKel, 0, 2);
            foreach ($pilihan as $kel) {
                foreach (['2024', '2025', '2026'] as $tahun) {
                    foreach (['Remaja', 'Orang Tua'] as $kelompok) {
                        $pre = mt_rand(400, 650) / 10;                       // 40,0 - 65,0
                        $post = min(98, $pre + mt_rand(100, 250) / 10);      // naik 10 - 25 poin
                        $baris[] = [
                            'kelompok'       => $kelompok,
                            'kecamatan'      => $kec,
                            'kelurahan'      => $kel,
                            'tahun'          => $tahun,
                            'nilai_pre'      => round($pre, 2),
                            'nilai_post'     => round($post, 2),
                            'jumlah_peserta' => mt_rand(15, 60),
                            'created_at'     => self::PENANDA,
                            'updated_at'     => self::PENANDA,
                        ];
                    }
                }
            }
        }

        foreach (array_chunk($baris, 100) as $bagian) {
            DB::table('kemangi')->insert($bagian);
        }

        $this->command?->info(count($baris) . ' data dummy Kemangi dibuat.');
    }

    // Kecamatan dan kelurahan dari tabel wilayah; ada cadangan bila tabel kosong
    private function ambilWilayah(): array
    {
        $hasil = [];
        try {
            $kec = DB::table('m_kecamatan')->whereNull('deleted_at')->orderBy('nama_kec')->get(['id_kec', 'nama_kec']);
            $kel = DB::table('m_kelurahan')->orderBy('nama_kel')->get(['no_kec', 'nama_kel'])->groupBy('no_kec');
            foreach ($kec as $k) {
                $daftar = ($kel[$k->id_kec] ?? collect())->pluck('nama_kel')->values()->all();
                if ($daftar) {
                    $hasil[$k->nama_kec] = $daftar;
                }
            }
        } catch (\Throwable $e) {
            // pakai cadangan di bawah
        }
        return $hasil ?: [
            'GUBENG'    => ['AIRLANGGA', 'GUBENG'],
            'RUNGKUT'   => ['KALIRUNGKUT', 'WONOREJO'],
            'SUKOLILO'  => ['KEPUTIH', 'SEMOLOWARU'],
            'WONOKROMO' => ['DARMO', 'NGAGEL'],
            'TANDES'    => ['BALONGSARI', 'TANDES'],
        ];
    }
}
