<?php

namespace Database\Seeders;

use App\Models\Bumil;
use App\Models\BumilCalonPengantin;
use App\Models\BumilKehamilan;
use App\Models\BumilAnak;
use App\Models\BumilNifas;
use App\Models\BumilPersalinan;
use App\Models\BumilRisiko;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * DATA DUMMY Pendampingan Ibu Hamil.
 * Semua data dummy memakai No KK berawalan 9900 (tidak ada di dunia nyata),
 * jadi mudah dikenali dan dihapus. Menjalankan seeder ini berulang kali tidak
 * menggandakan data: data dummy lama dibersihkan dulu.
 *
 * Jalankan : php artisan db:seed --class=BumilDummySeeder
 * Hapus    : php artisan tinker, lalu jalankan baris penghapusan dari catatan Claude
 *            (cari semua data dengan No KK berawalan 9900).
 */
class BumilDummySeeder extends Seeder
{
    private const AWALAN = '9900';

    public function run(): void
    {
        if (!Schema::hasTable('bumil')) {
            $this->command?->error('Tabel bumil belum ada. Jalankan migrasinya dulu.');
            return;
        }
        $adaRiwayat = Schema::hasTable('bumil_kehamilan') && Schema::hasTable('bumil_calon_pengantin');
        if (!$adaRiwayat) {
            $this->command?->warn('Tabel riwayat belum ada: hanya data ibu yang dibuat (tanpa riwayat).');
        }

        $adaBaru = Schema::hasTable('bumil_risiko') && Schema::hasTable('bumil_persalinan')
            && Schema::hasTable('bumil_nifas') && Schema::hasTable('bumil_anak');
        if (!$adaBaru) {
            $this->command?->warn('Tabel risiko/persalinan/nifas/anak belum ada: data tambahan dilewati. Jalankan migrasinya dulu.');
        }
        $adaHamilKe = Schema::hasColumn('bumil', 'hamil_ke') && Schema::hasColumn('bumil', 'tanggal_melahirkan');

        mt_srand(20261028);
        $this->bersihkan($adaRiwayat, $adaBaru);

        $wilayah = $this->ambilWilayah();
        $namaDepan = ['Siti', 'Dewi', 'Ayu', 'Rina', 'Fitri', 'Lestari', 'Wulan', 'Putri', 'Indah', 'Nur', 'Sri', 'Yuni', 'Rahma', 'Maya', 'Citra', 'Dian', 'Eka', 'Nia', 'Tika', 'Sari'];
        $namaBelakang = ['Rahayu', 'Wati', 'Handayani', 'Permata', 'Safitri', 'Maharani', 'Anggraini', 'Puspita', 'Utami', 'Ningsih', 'Kusuma', 'Lestari', 'Wijaya', 'Hidayah', 'Amelia'];
        $jalan = ['Kenanga', 'Melati', 'Mawar', 'Anggrek', 'Flamboyan', 'Dahlia', 'Cempaka', 'Teratai', 'Kamboja', 'Seruni'];
        $hasilCatin = [
            'Sehat, siap menikah',
            'Status gizi normal',
            'Anemia ringan, diberi tablet tambah darah',
            'LILA kurang, perlu pendampingan gizi',
            'Sehat, disarankan konsultasi pra nikah',
        ];

        $daftarRisiko = [
            ['Anemia', 'Hb di bawah 11 g/dL'],
            ['Hipertensi', 'Tekanan darah di atas 140/90'],
            ['Terlalu muda (< 20 tahun)', 'Usia ibu di bawah 20 tahun'],
            ['Terlalu tua (> 35 tahun)', 'Usia ibu di atas 35 tahun'],
            ['Jarak kehamilan terlalu dekat', 'Jarak dengan persalinan sebelumnya kurang dari 2 tahun'],
            ['Riwayat operasi sesar', 'Persalinan sebelumnya melalui sesar'],
        ];
        $caraPersalinan = ['Normal', 'Normal', 'Normal', 'Sectio Caesarea', 'Vakum'];
        $tempatPersalinan = ['Puskesmas', 'Rumah Sakit', 'Klinik Bersalin', 'Bidan Praktik Mandiri'];
        $namaAnak = ['Aisyah', 'Zahra', 'Naufal', 'Rafa', 'Alya', 'Khanza', 'Arkan', 'Nabila', 'Fajar', 'Keisha'];
        $kondisiNifas = ['Baik, tidak ada keluhan', 'Sehat, ASI lancar', 'Nyeri jahitan ringan', 'Perlu pantauan tekanan darah'];

        $hari = Carbon::create(2026, 10, 28);
        $jumlah = 70;      // 55 ibu hamil + 15 ibu nifas
        $dipakai = [];

        for ($i = 1; $i <= $jumlah; $i++) {
            $nifas = $i > 55;
            $kec = $wilayah['kecamatan'][mt_rand(0, count($wilayah['kecamatan']) - 1)];
            $daftarKel = $wilayah['kelurahan'][$kec] ?? [];
            $kel = $daftarKel ? $daftarKel[mt_rand(0, count($daftarKel) - 1)] : null;

            $tinggi = mt_rand(148, 168);
            $bb = mt_rand(46, 72) + mt_rand(0, 9) / 10;
            $lila = mt_rand(21, 29) + mt_rand(0, 9) / 10;
            $kek = $lila < 23.5;
            $resti = !$nifas && (mt_rand(1, 100) <= 22);

            // tanggal pendataan: sebagian besar 2026, sebagian 2025
            $tanggal = mt_rand(1, 100) <= 75
                ? Carbon::create(2026, mt_rand(1, 10), mt_rand(1, 28))
                : Carbon::create(2025, mt_rand(1, 12), mt_rand(1, 28));
            if ($tanggal->gt($hari)) {
                $tanggal = $hari->copy();
            }

            $nik = self::AWALAN . str_pad((string) (1000000000 + $i), 12, '0', STR_PAD_LEFT);
            $ibu = Bumil::create([
                'kategori'   => $nifas ? 'nifas' : 'hamil',
                'no_kk'      => self::AWALAN . str_pad((string) (500000000 + $i), 12, '0', STR_PAD_LEFT),
                'nik'        => $nik,
                'nama'       => $this->namaUnik($namaDepan, $namaBelakang, $dipakai),
                'usia'       => mt_rand(19, 38),
                'alamat'     => 'Jl. ' . $jalan[mt_rand(0, count($jalan) - 1)] . ' No. ' . mt_rand(1, 60),
                'kecamatan'  => $kec,
                'kelurahan'  => $kel,
                'rw'         => str_pad((string) mt_rand(1, 12), 2, '0', STR_PAD_LEFT),
                'rt'         => str_pad((string) mt_rand(1, 9), 2, '0', STR_PAD_LEFT),
                'status_kek' => $nifas ? null : ($kek ? 'KEK' : 'Tidak KEK'),
                'resti'      => $resti,
                'tanggal'    => $tanggal->toDateString(),
            ]);

            // ---- Kehamilan ke berapa + tanggal melahirkan (nifas) ----
            $hamilKe = mt_rand(1, 4);
            $tglLahir = $nifas ? $tanggal->copy()->subWeeks(mt_rand(2, 6)) : null;
            if ($adaHamilKe) {
                $ibu->forceFill([
                    'hamil_ke'           => $hamilKe,
                    'tanggal_melahirkan' => $tglLahir?->toDateString(),
                ])->save();
            }

            if ($adaBaru) {
                // ---- Risiko kehamilan ----
                if (!$nifas) {
                    if ($kek) {
                        BumilRisiko::create([
                            'bumil_id'     => $ibu->id,
                            'jenis_risiko' => 'KEK',
                            'keterangan'   => 'LILA ' . $lila . ' cm (di bawah 23,5 cm)',
                            'tanggal'      => $tanggal->toDateString(),
                        ]);
                    }
                    if ($resti) {
                        $jumlahRisiko = mt_rand(1, 2);
                        $pilihan = array_rand($daftarRisiko, $jumlahRisiko);
                        foreach ((array) $pilihan as $idx) {
                            BumilRisiko::create([
                                'bumil_id'     => $ibu->id,
                                'jenis_risiko' => $daftarRisiko[$idx][0],
                                'keterangan'   => $daftarRisiko[$idx][1],
                                'tanggal'      => $tanggal->toDateString(),
                            ]);
                        }
                    }
                }

                // ---- Persalinan (kehamilan yang sudah berakhir) + anak + nifas ----
                // Ibu hamil: kehamilan sebelumnya saja. Ibu nifas: termasuk persalinan terakhir.
                $jumlahPersalinan = $nifas ? $hamilKe : $hamilKe - 1;
                for ($ke = 1; $ke <= $jumlahPersalinan; $ke++) {
                    $terakhir = $nifas && $ke === $hamilKe;
                    $tglP = $terakhir
                        ? $tglLahir->copy()
                        : $tanggal->copy()->subMonths(($hamilKe - $ke) * 22 + mt_rand(0, 6));

                    $r = mt_rand(1, 100);
                    if ($terakhir) {
                        $status = $r <= 93 ? 'lahir_hidup' : 'lahir_mati';
                    } else {
                        $status = $r <= 85 ? 'lahir_hidup' : ($r <= 92 ? 'keguguran' : 'lahir_mati');
                    }

                    $persalinan = BumilPersalinan::create([
                        'bumil_id'          => $ibu->id,
                        'hamil_ke'          => $ke,
                        'tanggal'           => $tglP->toDateString(),
                        'cara_persalinan'   => $status === 'keguguran' ? null : $caraPersalinan[mt_rand(0, count($caraPersalinan) - 1)],
                        'tempat_persalinan' => $tempatPersalinan[mt_rand(0, count($tempatPersalinan) - 1)],
                        'status_kelahiran'  => $status,
                    ]);

                    if ($status !== 'keguguran') {
                        $kembar = mt_rand(1, 100) <= 4;
                        for ($a = 0; $a < ($kembar ? 2 : 1); $a++) {
                            BumilAnak::create([
                                'persalinan_id' => $persalinan->id,
                                'nama'          => $status === 'lahir_hidup' ? $namaAnak[mt_rand(0, count($namaAnak) - 1)] : null,
                                'jenis_kelamin' => mt_rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                                'tanggal_lahir' => $tglP->toDateString(),
                                'berat_lahir'   => $kembar ? mt_rand(1900, 3000) : mt_rand(2200, 3800),
                                'panjang_lahir' => mt_rand(440, 520) / 10,
                            ]);
                        }
                    }

                    if ($terakhir) {
                        foreach ([3, 14, 40] as $hariNifas) {
                            $tglN = $tglP->copy()->addDays($hariNifas);
                            if ($tglN->gt($tanggal)) {
                                continue;
                            }
                            BumilNifas::create([
                                'bumil_id'      => $ibu->id,
                                'persalinan_id' => $persalinan->id,
                                'tanggal'       => $tglN->toDateString(),
                                'hari_nifas'    => $hariNifas,
                                'tensi'         => mt_rand(100, 125) . '/' . mt_rand(65, 80),
                                'suhu'          => mt_rand(362, 375) / 10,
                                'kondisi_ibu'   => $kondisiNifas[mt_rand(0, count($kondisiNifas) - 1)],
                            ]);
                        }
                    }
                }
            }

            if (!$adaRiwayat) {
                continue;
            }

            // Riwayat kehamilan: 1 sampai 3 kunjungan, tiap 4 minggu
            $kunjungan = mt_rand(1, 3);
            $usiaAkhir = $nifas ? mt_rand(36, 40) : mt_rand(10, 38);
            $akhir = $nifas ? $tglLahir->copy() : $tanggal->copy();
            for ($k = 0; $k < $kunjungan; $k++) {
                $mundur = $kunjungan - 1 - $k;
                $usia = max(4, $usiaAkhir - 4 * $mundur);
                $bbK = $bb - $mundur * 0.8;
                BumilKehamilan::create([
                    'bumil_id'       => $ibu->id,
                    'tanggal'        => $akhir->copy()->subWeeks(4 * $mundur)->toDateString(),
                    'usia_kehamilan' => $usia,
                    'hb'             => mt_rand(95, 135) / 10,
                    'bb'             => round($bbK, 1),
                    'tb'             => $tinggi,
                    'imt'            => round($bbK / (($tinggi / 100) ** 2), 2),
                    'lila'           => $lila,
                    'tensi'          => $resti && $k === $kunjungan - 1 ? mt_rand(140, 155) . '/' . mt_rand(90, 100) : mt_rand(100, 125) . '/' . mt_rand(65, 80),
                    'tfu'            => $usia >= 20 ? $usia : null,
                    'djj'            => mt_rand(120, 160),
                ]);
            }

            // Riwayat calon pengantin: sebagian ibu punya 1 catatan
            if (mt_rand(1, 100) <= 55) {
                $bbC = $bb - mt_rand(2, 8);
                BumilCalonPengantin::create([
                    'bumil_id'          => $ibu->id,
                    'nik'               => $nik,
                    'tanggal'           => $tanggal->copy()->subMonths(mt_rand(14, 40))->toDateString(),
                    'hasil_pemeriksaan' => $hasilCatin[mt_rand(0, count($hasilCatin) - 1)],
                    'bb'                => round($bbC, 1),
                    'tb'                => $tinggi,
                    'lila'              => max(21, $lila - 0.5),
                    'imt'               => round($bbC / (($tinggi / 100) ** 2), 2),
                ]);
            }
        }

        $this->command?->info("Selesai: {$jumlah} data dummy ibu hamil dan nifas dibuat.");
    }

    private function bersihkan(bool $adaRiwayat, bool $adaBaru = false): void
    {
        $ids = Bumil::withTrashed()->where('no_kk', 'like', self::AWALAN . '%')->pluck('id');
        if ($ids->isEmpty()) {
            return;
        }
        if ($adaBaru) {
            $idPersalinan = BumilPersalinan::withTrashed()->whereIn('bumil_id', $ids)->pluck('id');
            BumilAnak::withTrashed()->whereIn('persalinan_id', $idPersalinan)->forceDelete();
            BumilNifas::withTrashed()->whereIn('bumil_id', $ids)->forceDelete();
            BumilPersalinan::withTrashed()->whereIn('bumil_id', $ids)->forceDelete();
            BumilRisiko::withTrashed()->whereIn('bumil_id', $ids)->forceDelete();
        }
        if ($adaRiwayat) {
            BumilKehamilan::withTrashed()->whereIn('bumil_id', $ids)->forceDelete();
            BumilCalonPengantin::withTrashed()->whereIn('bumil_id', $ids)->forceDelete();
        }
        Bumil::withTrashed()->whereIn('id', $ids)->forceDelete();
    }

    private function namaUnik(array $depan, array $belakang, array &$dipakai): string
    {
        do {
            $nama = $depan[mt_rand(0, count($depan) - 1)] . ' ' . $belakang[mt_rand(0, count($belakang) - 1)];
        } while (isset($dipakai[$nama]) && count($dipakai) < count($depan) * count($belakang));
        $dipakai[$nama] = true;
        return $nama;
    }

    // Kecamatan + kelurahan dari tabel wilayah; cadangan bila tabel kosong
    private function ambilWilayah(): array
    {
        $hasil = ['kecamatan' => [], 'kelurahan' => []];
        try {
            $kec = DB::table('m_kecamatan')->whereNull('deleted_at')->orderBy('nama_kec')->get(['id_kec', 'nama_kec']);
            $kel = DB::table('m_kelurahan')->get(['no_kec', 'nama_kel'])->groupBy('no_kec');
            foreach ($kec as $k) {
                $hasil['kecamatan'][] = $k->nama_kec;
                $hasil['kelurahan'][$k->nama_kec] = ($kel[$k->id_kec] ?? collect())->pluck('nama_kel')->values()->all();
            }
        } catch (\Throwable $e) {
            // dibiarkan, pakai cadangan di bawah
        }
        if (!$hasil['kecamatan']) {
            $hasil['kecamatan'] = ['GUBENG', 'RUNGKUT', 'SUKOLILO', 'WONOKROMO', 'TANDES', 'GENTENG'];
            $hasil['kelurahan'] = [
                'GUBENG' => ['AIRLANGGA', 'GUBENG', 'MOJO'], 'RUNGKUT' => ['KALIRUNGKUT', 'WONOREJO'],
                'SUKOLILO' => ['KEPUTIH', 'SEMOLOWARU'], 'WONOKROMO' => ['DARMO', 'NGAGEL'],
                'TANDES' => ['BALONGSARI', 'TANDES'], 'GENTENG' => ['GENTENG', 'KETABANG'],
            ];
        }
        return $hasil;
    }
}