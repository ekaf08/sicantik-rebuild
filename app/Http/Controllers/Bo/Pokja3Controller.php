<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class Pokja3Controller extends Controller
{
    public const KADER_ALIASES = [
        'jml_kdr_pangan',
        'jml_kdr_sandang',
        'jml_kdr_tt_laksana_rt',
    ];

    /**
     * 1. Ambil data rekap Pokja 3 (dipanggil oleh DashboardController & DataUmumController)
     * - Jika $idKec === null : rekap per kecamatan (SUM seluruh kelurahan)
     * - Jika $idKec !== null : rekap per kelurahan dalam kecamatan tersebut
     */
    public static function getRekapData(int $periode = 2026, ?int $idKec = null): array
    {
        $kolomPokja3 = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->whereNull('deleted_at')
            ->orderBy('urutan')
            ->get();

        if ($idKec === null) {
            $sum = $kolomPokja3->pluck('alias')
                ->map(fn ($a) => 'SUM("' . str_replace('"', '""', $a) . '") AS "' . str_replace('"', '""', $a) . '"')
                ->implode(', ');

            $dataPokja3 = $kolomPokja3->isEmpty()
                ? collect()
                : DB::table('d_pokja_3_2026')
                    ->selectRaw("id_kec, $sum")
                    ->where('periode', $periode)
                    ->whereNotNull('id_kel')
                    ->groupBy('id_kec')
                    ->get()
                    ->keyBy('id_kec');
        } else {
            $dataPokja3 = DB::table('d_pokja_3_2026')
                ->where('id_kec', $idKec)
                ->where('periode', $periode)
                ->whereNotNull('id_kel')
                ->get()
                ->keyBy('id_kel');
        }

        // Hitung ulang jumlah kader Pokja 3 langsung dari d_kader_2026
        $groupKey = $idKec === null ? 'id_kec' : 'id_kel';

        $cacahKader = DB::table('d_kader_2026')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereIn('jenis_kader', self::KADER_ALIASES)
            ->when($idKec !== null, fn ($q) => $q->where('id_kec', $idKec))
            ->selectRaw("$groupKey, jenis_kader, COUNT(*) AS total")
            ->groupBy($groupKey, 'jenis_kader')
            ->get();

        foreach ($cacahKader as $r) {
            $key = $r->{$groupKey};
            if (!$dataPokja3->has($key)) {
                $dataPokja3[$key] = (object) [$groupKey => $key];
            }
            $dataPokja3[$key]->{$r->jenis_kader} = $r->total;
        }

        return [
            'kolomPokja3' => $kolomPokja3,
            'dataPokja3'  => $dataPokja3,
        ];
    }

    /**
     * 2. Cari data warga berdasarkan NIK (untuk tombol "Cari" di modal Tambah Data)
     */
    public function cariNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|min:16|max:20',
        ]);

        $nik = trim($request->query('nik'));

        // Cek di d_penduduk_2026 terlebih dahulu
        $warga = DB::table('d_penduduk_2026')
            ->where('nik', $nik)
            ->whereNull('deleted_at')
            ->first();

        // Fallback: cek riwayat di d_kader_2026 jika sudah pernah diinput di pokja lain
        if (!$warga) {
            $warga = DB::table('d_kader_2026')
                ->where('nik', $nik)
                ->whereNull('deleted_at')
                ->orderByDesc('id')
                ->first();
        }

        if (!$warga) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Data NIK tidak ditemukan, silakan lengkapi form secara manual.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'nik'           => $warga->nik,
                'no_kk'         => $warga->no_kk ?? '',
                'nama'          => $warga->nama ?? '',
                'no_hp'         => $warga->no_hp ?? '',
                'alamat'        => $warga->alamat ?? '',
                'rw'            => $warga->rw ?? '',
                'rt'            => $warga->rt ?? '',
                'jenis_kelamin' => $warga->jenis_kelamin ?? '',
            ],
        ]);
    }

    /**
     * 3. Simpan kader baru dari Modal Tambah Data + Auto-Sync ke d_pokja_3_2026
     */
    public function storeKader(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer',
            'periode'       => 'nullable|integer',
            'nik'           => 'required|string|size:16',
            'no_kk'         => 'nullable|string|max:20',
            'nama'          => 'required|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'rw'            => 'nullable|string|max:10',
            'rt'            => 'nullable|string|max:10',
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'jabatan'       => ['required', Rule::in(['Ketua', 'Wakil Ketua', 'Sekretaris', 'Anggota'])],
        ]);

        $periode = (int) ($validated['periode'] ?? 2026);

        // Ambil metadata pertanyaan untuk menentukan jenis_kader dari kolom alias
        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->where('is_kader', true)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator kader Pokja 3 tidak valid.');

        $jenisKader = $pertanyaan->alias; // e.g. 'jumlah_kader_pangan'

        try {
            DB::transaction(function () use ($validated, $periode, $jenisKader, $pertanyaan) {
                DB::table('d_kader_2026')->insert([
                    'id_kec'        => $validated['id_kec'],
                    'id_kel'        => $validated['id_kel'],
                    'periode'       => $periode,
                    'jenis_kader'   => $jenisKader,
                    'nik'           => $validated['nik'],
                    'nama'          => $validated['nama'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'no_kk'         => $validated['no_kk'] ?? null,
                    'rw'            => $validated['rw'] ?? null,
                    'rt'            => $validated['rt'] ?? null,
                    'alamat'        => $validated['alamat'] ?? null,
                    'no_hp'         => $validated['no_hp'] ?? null,
                    'jabatan'       => $validated['jabatan'], // Ketua / Wakil Ketua / Sekretaris / Anggota
                    'nama_role'     => $pertanyaan->nama_pertanyaan,
                    'created_by'    => Auth::id(),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                $this->syncJumlahKader($validated['id_kec'], $validated['id_kel'], $periode, $jenisKader);
            });
        } catch (QueryException $e) {
            // Tangkap pelanggaran Partial Unique Index (SQLSTATE 23505)
            if ($e->getCode() === '23505') {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'NIK tersebut sudah terdaftar pada kategori kader ini di periode ' . $periode . '.',
                ], 422);
            }
            throw $e;
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data kader berhasil ditambahkan.',
        ]);
    }

    /**
     * 4. Soft delete kader + Auto-Sync hitung ulang ke d_pokja_3_2026
     */
    public function destroyKader($id)
    {
        $kader = DB::table('d_kader_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$kader, 404, 'Data kader tidak ditemukan.');

        DB::transaction(function () use ($kader) {
            DB::table('d_kader_2026')
                ->where('id', $kader->id)
                ->update([
                    'deleted_by' => Auth::id(),
                    'deleted_at' => now(),
                ]);

            $this->syncJumlahKader($kader->id_kec, $kader->id_kel, $kader->periode, $kader->jenis_kader);
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Data kader berhasil dihapus.',
        ]);
    }

    /**
     * 5. Direct update untuk 14 kolom angka kuantitatif non-kader (Beras, Rumah Sehat, dll.)
     */
    public function updateAgregat(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer|min:1',
            'periode'       => 'nullable|integer',
            'nilai'         => 'required|numeric|min:0',
        ]);

        $periode = (int) ($validated['periode'] ?? 2026);

        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->where('is_kader', false)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator Pokja 3 tidak valid.');

        $kolom = $pertanyaan->alias;
        abort_unless(Schema::hasColumn('d_pokja_3_2026', $kolom), 422, 'Kolom target tidak ditemukan.');

        DB::table('d_pokja_3_2026')->updateOrInsert(
            [
                'id_kec'  => $validated['id_kec'],
                'id_kel'  => $validated['id_kel'],
                'periode' => $periode,
            ],
            [
                $kolom       => $validated['nilai'],
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ]);
    }

    /**
     * Helper internal untuk menyinkronkan COUNT dari d_kader_2026 ke d_pokja_3_2026
     */
    private function syncJumlahKader(int $idKec, int $idKel, int $periode, string $jenisKader): void
    {
        if ($idKel <= 0 || !Schema::hasColumn('d_pokja_3_2026', $jenisKader)) {
            return;
        }

        $total = DB::table('d_kader_2026')
            ->where('id_kec', $idKec)
            ->where('id_kel', $idKel)
            ->where('periode', $periode)
            ->where('jenis_kader', $jenisKader)
            ->whereNull('deleted_at')
            ->count();

        DB::table('d_pokja_3_2026')->updateOrInsert(
            [
                'id_kec'  => $idKec,
                'id_kel'  => $idKel,
                'periode' => $periode,
            ],
            [
                $jenisKader  => $total,
                'updated_at' => now(),
            ]
        );
    }
}