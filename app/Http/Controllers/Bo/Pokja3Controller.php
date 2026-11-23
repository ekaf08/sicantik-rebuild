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
    public static function getRekapData(int $periode = 2026, ?int $idKec = null): array
    {
        $kolomPokja3 = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->whereNull('deleted_at')
            ->orderBy('urutan')
            ->get();

        $aliases      = $kolomPokja3->pluck('alias')->all();
        $kaderAliases = $kolomPokja3->filter(fn ($k) => (bool) $k->is_kader)->pluck('alias')->all();

        $perKel = DB::table('d_pokja_3_2026')
            ->where('periode', $periode)
            ->whereNotNull('id_kel')
            ->when($idKec !== null, fn ($q) => $q->where('id_kec', $idKec))
            ->get()
            ->keyBy('id_kel');

        $pastikanBaris = function ($r) use ($perKel) {
            if (!$perKel->has($r->id_kel)) {
                $perKel[$r->id_kel] = (object) ['id_kec' => $r->id_kec, 'id_kel' => $r->id_kel];
            }
        };

        $cacahKader = DB::table('d_kader_2026')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereIn('jenis_kader', $kaderAliases)
            ->where('id_kel', '>', 0)
            ->when($idKec !== null, fn ($q) => $q->where('id_kec', $idKec))
            ->selectRaw('id_kec, id_kel, jenis_kader, COUNT(*) AS total')
            ->groupBy('id_kec', 'id_kel', 'jenis_kader')
            ->get();

        foreach ($cacahKader as $r) {
            $pastikanBaris($r);
            $perKel[$r->id_kel]->{$r->jenis_kader} = $r->total;
        }

        $cacahToga = DB::table('d_toga_2026')
            ->where('periode', $periode)
            ->where('nama_jawaban', 'Ya')
            ->whereNull('deleted_at')
            ->where('id_kel', '>', 0)
            ->when($idKec !== null, fn ($q) => $q->where('id_kec', $idKec))
            ->selectRaw('id_kec, id_kel, COUNT(*) AS total')
            ->groupBy('id_kec', 'id_kel')
            ->get();

        foreach ($cacahToga as $r) {
            $pastikanBaris($r);
            $perKel[$r->id_kel]->pekarangan_toga = $r->total;
        }

        if ($idKec !== null) {
            return ['kolomPokja3' => $kolomPokja3, 'dataPokja3' => $perKel];
        }

        $dataPokja3 = $perKel->groupBy('id_kec')->map(function ($rows, $kec) use ($aliases) {
            $o = new \stdClass();
            $o->id_kec = $kec;
            foreach ($aliases as $a) {
                $o->$a = $rows->sum(fn ($r) => (int) ($r->$a ?? 0));
            }
            return $o;
        });

        return ['kolomPokja3' => $kolomPokja3, 'dataPokja3' => $dataPokja3];
    }

    public function cariNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
        ]);

        $nik = trim($request->query('nik'));

        $warga = DB::table('d_penduduk_2026')
            ->where('nik', $nik)
            ->whereNull('deleted_at')
            ->first();

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

    public function storeKader(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer',
            'periode'       => 'nullable|integer',
            'nik'           => 'required|digits:16',
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

        abort_unless($this->wilayahValid($validated['id_kec'], $validated['id_kel']), 422, 'Kelurahan tidak sesuai dengan kecamatan.');

       $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->where(fn ($q) => $q->whereNull('is_kader')->orWhere('is_kader', false))
            ->whereIn('jenis_form', [1, 2])
            ->where(fn ($q) => $q->whereNull('is_disable')->orWhere('is_disable', false))
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator kader Pokja 3 tidak valid.');

        $jenisKader = $pertanyaan->alias; // e.g. 'kader_pangan'

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
    public function destroyKader($id)
    {
        $kader = DB::table('d_kader_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$kader, 404, 'Data kader tidak ditemukan.');

        // Hanya kader Pokja 3 yang boleh dihapus lewat endpoint ini
        $kaderPokja3 = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->where('is_kader', true)
            ->whereNull('deleted_at')
            ->where('alias', $kader->jenis_kader)
            ->exists();

        abort_unless($kaderPokja3, 422, 'Data ini bukan kader Pokja 3.');

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
    public function updateKader(Request $request, $id)
    {
        $validated = $request->validate([
            'nik'           => 'required|digits:16',
            'no_kk'         => 'nullable|string|max:20',
            'nama'          => 'required|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'rw'            => 'nullable|string|max:10',
            'rt'            => 'nullable|string|max:10',
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'jabatan'       => ['required', Rule::in(['Ketua', 'Wakil Ketua', 'Sekretaris', 'Anggota'])],
        ]);

        $kader = DB::table('d_kader_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$kader, 404, 'Data kader tidak ditemukan.');

        $kaderPokja3 = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->where('is_kader', true)
            ->whereNull('deleted_at')
            ->where('alias', $kader->jenis_kader)
            ->exists();

        abort_unless($kaderPokja3, 422, 'Data ini bukan kader Pokja 3.');

        try {
            DB::table('d_kader_2026')->where('id', $kader->id)->update([
                'nik'           => $validated['nik'],
                'nama'          => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_kk'         => $validated['no_kk'] ?? null,
                'rw'            => $validated['rw'] ?? null,
                'rt'            => $validated['rt'] ?? null,
                'alamat'        => $validated['alamat'] ?? null,
                'no_hp'         => $validated['no_hp'] ?? null,
                'jabatan'       => $validated['jabatan'],
                'updated_at'    => now(),
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23505') {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'NIK tersebut sudah terdaftar pada kategori kader ini di periode ' . $kader->periode . '.',
                ], 422);
            }
            throw $e;
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data kader berhasil diperbarui.',
        ]);
    }

    public function updateAgregat(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer|min:1',
            'periode'       => 'nullable|integer',
            'nilai'         => 'required|integer|min:0|max:2147483647',
        ]);

        $periode = (int) ($validated['periode'] ?? 2026);

        abort_unless($this->wilayahValid($validated['id_kec'], $validated['id_kel']), 422, 'Kelurahan tidak sesuai dengan kecamatan.');

        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', 'd_pokja_3_2026')
            ->where('is_kader', false)
            ->whereIn('jenis_form', [1, 2])
            ->where(fn ($q) => $q->whereNull('is_disable')->orWhere('is_disable', false))
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator Pokja 3 tidak valid.');

        $kolom = $pertanyaan->alias;
        abort_unless(Schema::hasColumn('d_pokja_3_2026', $kolom), 422, 'Kolom target tidak ditemukan.');

        $this->upsertPokja3($validated['id_kec'], $validated['id_kel'], $periode, [$kolom => $validated['nilai']]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ]);
    }

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

        $this->upsertPokja3($idKec, $idKel, $periode, [$jenisKader => $total]);
    }

     
    public function syncJumlahToga(int $idKec, int $idKel, int $periode): void
    {
        if ($idKel <= 0) {
            return;
        }

        $total = DB::table('d_toga_2026')
            ->where('id_kec', $idKec)
            ->where('id_kel', $idKel)
            ->where('periode', $periode)
            ->where('nama_jawaban', 'Ya')
            ->whereNull('deleted_at')
            ->count();

        $this->upsertPokja3($idKec, $idKel, $periode, ['pekarangan_toga' => $total]);
    }

    private function upsertPokja3(int $idKec, int $idKel, int $periode, array $values): void
    {
        $key = ['id_kec' => $idKec, 'id_kel' => $idKel, 'periode' => $periode];

        $updated = DB::table('d_pokja_3_2026')->where($key)->update($values + ['updated_at' => now()]);

        if (!$updated) {
            DB::table('d_pokja_3_2026')->insert($key + $values + [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function wilayahValid(int $idKec, int $idKel): bool
    {
        return DB::table('m_kelurahan as kl')
            ->join('m_kecamatan as kc', 'kc.kode_bpjs', '=', 'kl.kode_kec_bpjs')
            ->where('kl.id_kel', $idKel)
            ->where('kc.id_kec', $idKec)
            ->exists();
    }
}