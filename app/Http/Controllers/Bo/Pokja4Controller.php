<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Support\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Pokja4Controller extends Controller
{
    private const TABEL = 'd_pokja_4_2026';

    private const KADER_ALIASES = [
        'kader_kesehatan',
        'gizi',
        'kesling',
        'phbs',
        'kb',
        'kader_sby_hebat',
    ];

    private const GKSTB_ALIASES = [
        'kesehatan',
        'kelestarian_lh',
        'perencanaan_sehat',
    ];

    private const SUMBER = [
        'posyandu' => [
            'tabel'  => 'd_posyandu_2026',
            'hitung' => 'COUNT(*)',
        ],
        'jumlah_pus' => [
            'tabel'    => 'd_penduduk_2026',
            'hitung'   => 'COUNT(DISTINCT no_kk)',
            'whereRaw' => "EXISTS (
                    SELECT 1 FROM d_penduduk_2026 l
                    WHERE l.no_kk = d_penduduk_2026.no_kk AND l.periode = d_penduduk_2026.periode AND l.deleted_at IS NULL
                      AND l.jenis_kelamin = 'L'
                ) AND EXISTS (
                    SELECT 1 FROM d_penduduk_2026 p
                    WHERE p.no_kk = d_penduduk_2026.no_kk AND p.periode = d_penduduk_2026.periode AND p.deleted_at IS NULL
                      AND p.jenis_kelamin = 'P' AND p.nik ~ '^[0-9]{16}$'
                      AND (EXTRACT(YEAR FROM CURRENT_DATE)::int - CASE WHEN SUBSTRING(p.nik, 11, 2)::int <= (EXTRACT(YEAR FROM CURRENT_DATE)::int % 100) THEN 2000 + SUBSTRING(p.nik, 11, 2)::int ELSE 1900 + SUBSTRING(p.nik, 11, 2)::int END) BETWEEN 15 AND 49
                )",
        ],
        'jumlah_wus' => [
            'tabel'    => 'd_penduduk_2026',
            'where'    => ['jenis_kelamin' => 'P'],
            'whereRaw' => "nik ~ '^[0-9]{16}$' AND (EXTRACT(YEAR FROM CURRENT_DATE)::int - CASE WHEN SUBSTRING(nik, 11, 2)::int <= (EXTRACT(YEAR FROM CURRENT_DATE)::int % 100) THEN 2000 + SUBSTRING(nik, 11, 2)::int ELSE 1900 + SUBSTRING(nik, 11, 2)::int END) BETWEEN 15 AND 49",
        ],
        'akseptor_kb_l' => [
            'tabel' => 'd_akseptor_kb_2026',
            'where' => ['jenis_kelamin' => 'L'],
        ],
        'akseptor_kb_p' => [
            'tabel' => 'd_akseptor_kb_2026',
            'where' => ['jenis_kelamin' => 'P'],
        ],
    ];

    /**
     * Ber-key id_kec bila $idKec null (level Kota),
     * ber-key id_kel (0 untuk tingkat kecamatan) bila $idKec terisi.
     */
    public static function getRekapData(int $periode = 2026, ?int $idKec = null, ?int $idKel = null): Collection
    {
        $aliases = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', self::TABEL)
            ->whereNull('deleted_at')
            ->pluck('alias')
            ->all();

        $initObj = function (array $base) use ($aliases) {
            $o = (object) $base;
            foreach ($aliases as $a) {
                $o->$a = (int) ($o->$a ?? 0);
            }
            return $o;
        };

        // Level Kelurahan / Kecamatan
        if ($idKec !== null) {
            $rowsDb = DB::table(self::TABEL)
                ->where('periode', $periode)
                ->where('id_kec', $idKec)
                ->when($idKel !== null, fn ($q) => $idKel === 0 ? $q->whereNull('id_kel') : $q->where('id_kel', $idKel))
                ->get();

            $perKel = collect();
            foreach ($rowsDb as $r) {
                $key = (int) ($r->id_kel ?? 0);
                $perKel[$key] = $initObj((array) $r);
            }

            foreach (self::SUMBER as $alias => $s) {
                foreach ($perKel as $row) {
                    $row->$alias = 0;
                }

                $rows = DB::table($s['tabel'])
                    ->where('periode', $periode)
                    ->whereNull('deleted_at')
                    ->where('id_kec', $idKec)
                    ->when($s['where'] ?? null, fn ($q, $w) => $q->where($w))
                    ->when($s['whereRaw'] ?? null, fn ($q, $w) => $q->whereRaw($w))
                    ->when($idKel !== null, fn ($q) => $q->whereRaw('COALESCE(id_kel, 0) = ?', [$idKel]))
                    ->selectRaw('COALESCE(id_kel, 0) AS id_kel, ' . ($s['hitung'] ?? 'COUNT(*)') . ' AS total')
                    ->groupByRaw('COALESCE(id_kel, 0)')
                    ->get();

                foreach ($rows as $r) {
                    $key = (int) $r->id_kel;
                    if (!$perKel->has($key)) {
                        $perKel[$key] = $initObj([
                            'id_kec' => $idKec,
                            'id_kel' => $key > 0 ? $key : null,
                        ]);
                    }
                    $perKel[$key]->$alias = (int) $r->total;
                }
            }

            // Hitung indikator detail warga (imunisasi, pkg, tbc, dll)
            $detailRows = DB::table('d_pokja_4_detail_2026 as d')
                ->join('m_pertanyaan_dashboard_2026 as p', 'p.id', '=', 'd.id_pertanyaan')
                ->where('p.tb_dashboard', self::TABEL)
                ->where('p.jenis_form', 2)
                ->whereNotIn('p.alias', self::GKSTB_ALIASES)
                ->whereNull('p.deleted_at')
                ->where('d.periode', $periode)
                ->whereNull('d.deleted_at')
                ->where('d.id_kec', $idKec)
                ->when($idKel !== null, fn ($q) => $q->whereRaw('COALESCE(d.id_kel, 0) = ?', [$idKel]))
                ->selectRaw('COALESCE(d.id_kel, 0) AS id_kel, p.alias, COUNT(*) AS total')
                ->groupByRaw('COALESCE(d.id_kel, 0), p.alias')
                ->get();

            foreach ($detailRows as $r) {
                $key = (int) $r->id_kel;
                if (!$perKel->has($key)) {
                    $perKel[$key] = $initObj([
                        'id_kec' => $idKec,
                        'id_kel' => $key > 0 ? $key : null,
                    ]);
                }
                $perKel[$key]->{$r->alias} = (int) $r->total;
            }

            // Hitung indikator GKSTTB (kesehatan, kelestarian_lh, perencanaan_sehat)
            $gkstbRows = DB::table('d_gkstb_2026 as d')
                ->join('m_pertanyaan_dashboard_2026 as p', 'p.id', '=', 'd.id_pertanyaan')
                ->where('p.tb_dashboard', self::TABEL)
                ->whereIn('p.alias', self::GKSTB_ALIASES)
                ->whereNull('p.deleted_at')
                ->where('d.periode', $periode)
                ->whereNull('d.deleted_at')
                ->where('d.id_kec', $idKec)
                ->when($idKel !== null, fn ($q) => $q->whereRaw('COALESCE(d.id_kel, 0) = ?', [$idKel]))
                ->selectRaw('COALESCE(d.id_kel, 0) AS id_kel, p.alias, COUNT(*) AS total')
                ->groupByRaw('COALESCE(d.id_kel, 0), p.alias')
                ->get();

            foreach ($gkstbRows as $r) {
                $key = (int) $r->id_kel;
                if (!$perKel->has($key)) {
                    $perKel[$key] = $initObj([
                        'id_kec' => $idKec,
                        'id_kel' => $key > 0 ? $key : null,
                    ]);
                }
                $perKel[$key]->{$r->alias} = (int) $r->total;
            }

            // Hitung 6 indikator kader Pokja 4 dari d_kader_2026
            foreach (self::KADER_ALIASES as $ka) {
                foreach ($perKel as $row) {
                    $row->$ka = 0;
                }
            }

            $kaderRows = DB::table('d_kader_2026')
                ->where('periode', $periode)
                ->whereNull('deleted_at')
                ->where('id_kec', $idKec)
                ->whereIn('jenis_kader', self::KADER_ALIASES)
                ->when($idKel !== null, fn ($q) => $q->whereRaw('COALESCE(id_kel, 0) = ?', [$idKel]))
                ->selectRaw('COALESCE(id_kel, 0) AS id_kel, jenis_kader, COUNT(*) AS total')
                ->groupByRaw('COALESCE(id_kel, 0), jenis_kader')
                ->get();

            foreach ($kaderRows as $r) {
                $key = (int) $r->id_kel;
                if (!$perKel->has($key)) {
                    $perKel[$key] = $initObj([
                        'id_kec' => $idKec,
                        'id_kel' => $key > 0 ? $key : null,
                    ]);
                }
                $perKel[$key]->{$r->jenis_kader} = (int) $r->total;
            }

            return $perKel;
        }

        // Level Kota
        $rowsDb = DB::table(self::TABEL)
            ->where('periode', $periode)
            ->get();

        $perKec = collect();
        foreach ($rowsDb->groupBy('id_kec') as $kec => $rows) {
            $o = $initObj(['id_kec' => (int) $kec]);
            foreach ($aliases as $a) {
                $o->$a = $rows->sum(fn ($r) => (int) ($r->$a ?? 0));
            }
            $perKec[(int) $kec] = $o;
        }

        foreach (self::SUMBER as $alias => $s) {
            foreach ($perKec as $row) {
                $row->$alias = 0;
            }

            $rows = DB::table($s['tabel'])
                ->where('periode', $periode)
                ->whereNull('deleted_at')
                ->when($s['where'] ?? null, fn ($q, $w) => $q->where($w))
                ->when($s['whereRaw'] ?? null, fn ($q, $w) => $q->whereRaw($w))
                ->selectRaw('id_kec, ' . ($s['hitung'] ?? 'COUNT(*)') . ' AS total')
                ->groupBy('id_kec')
                ->get();

            foreach ($rows as $r) {
                $kec = (int) $r->id_kec;
                if (!$perKec->has($kec)) {
                    $perKec[$kec] = $initObj(['id_kec' => $kec]);
                }
                $perKec[$kec]->$alias = (int) $r->total;
            }
        }

        $detailKota = DB::table('d_pokja_4_detail_2026 as d')
            ->join('m_pertanyaan_dashboard_2026 as p', 'p.id', '=', 'd.id_pertanyaan')
            ->where('p.tb_dashboard', self::TABEL)
            ->where('p.jenis_form', 2)
            ->whereNotIn('p.alias', self::GKSTB_ALIASES)
            ->whereNull('p.deleted_at')
            ->where('d.periode', $periode)
            ->whereNull('d.deleted_at')
            ->selectRaw('d.id_kec, p.alias, COUNT(*) AS total')
            ->groupBy('d.id_kec', 'p.alias')
            ->get();

        foreach ($detailKota as $r) {
            $kec = (int) $r->id_kec;
            if (!$perKec->has($kec)) {
                $perKec[$kec] = $initObj(['id_kec' => $kec]);
            }
            $perKec[$kec]->{$r->alias} = (int) $r->total;
        }

        $gkstbKota = DB::table('d_gkstb_2026 as d')
            ->join('m_pertanyaan_dashboard_2026 as p', 'p.id', '=', 'd.id_pertanyaan')
            ->where('p.tb_dashboard', self::TABEL)
            ->whereIn('p.alias', self::GKSTB_ALIASES)
            ->whereNull('p.deleted_at')
            ->where('d.periode', $periode)
            ->whereNull('d.deleted_at')
            ->selectRaw('d.id_kec, p.alias, COUNT(*) AS total')
            ->groupBy('d.id_kec', 'p.alias')
            ->get();

        foreach ($gkstbKota as $r) {
            $kec = (int) $r->id_kec;
            if (!$perKec->has($kec)) {
                $perKec[$kec] = $initObj(['id_kec' => $kec]);
            }
            $perKec[$kec]->{$r->alias} = (int) $r->total;
        }

        foreach (self::KADER_ALIASES as $ka) {
            foreach ($perKec as $row) {
                $row->$ka = 0;
            }
        }

        $kaderKota = DB::table('d_kader_2026')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereIn('jenis_kader', self::KADER_ALIASES)
            ->selectRaw('id_kec, jenis_kader, COUNT(*) AS total')
            ->groupBy('id_kec', 'jenis_kader')
            ->get();

        foreach ($kaderKota as $r) {
            $kec = (int) $r->id_kec;
            if (!$perKec->has($kec)) {
                $perKec[$kec] = $initObj(['id_kec' => $kec]);
            }
            $perKec[$kec]->{$r->jenis_kader} = (int) $r->total;
        }

        return $perKec;
    }

    public function updateAgregat(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer|min:1',
            'nilai'         => 'required|integer|min:0',
            'periode'       => 'nullable|integer',
        ]);

        $periode = (int) ($validated['periode'] ?? 2026);

        abort_unless(
            $this->wilayahValid($validated['id_kec'], $validated['id_kel']),
            422,
            'Kelurahan tidak sesuai dengan kecamatan.'
        );

        $this->cekAksesWilayah((int) $validated['id_kec'], (int) $validated['id_kel']);

        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', self::TABEL)
            ->where('jenis_form', 1)
            ->where(fn ($q) => $q->whereNull('is_kader')->orWhere('is_kader', false))
            ->where(fn ($q) => $q->whereNull('is_disable')->orWhere('is_disable', false))
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator agregat Pokja 4 tidak valid.');

        $kolom = $pertanyaan->alias;
        abort_unless(Schema::hasColumn(self::TABEL, $kolom), 422, 'Kolom indikator tidak ditemukan.');

        $existing = DB::table(self::TABEL)
            ->where('id_kec', $validated['id_kec'])
            ->where('id_kel', $validated['id_kel'])
            ->where('periode', $periode)
            ->first();

        if ($existing) {
            $update = [$kolom => (int) $validated['nilai']];
            if (Schema::hasColumn(self::TABEL, 'updated_by')) {
                $update['updated_by'] = auth()->id();
            }
            if (Schema::hasColumn(self::TABEL, 'updated_at')) {
                $update['updated_at'] = now();
            }

            DB::table(self::TABEL)->where('id', $existing->id)->update($update);
        } else {
            $insert = [
                'id_kec'  => $validated['id_kec'],
                'id_kel'  => $validated['id_kel'],
                'periode' => $periode,
                $kolom    => (int) $validated['nilai'],
            ];
            if (Schema::hasColumn(self::TABEL, 'created_by')) {
                $insert['created_by'] = auth()->id();
            }
            if (Schema::hasColumn(self::TABEL, 'created_at')) {
                $insert['created_at'] = now();
            }
            if (Schema::hasColumn(self::TABEL, 'updated_at')) {
                $insert['updated_at'] = now();
            }

            DB::table(self::TABEL)->insert($insert);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil disimpan.',
        ]);
    }

    public function cariNik(Request $request)
    {
        $nik     = trim((string) $request->query('nik', ''));
        $periode = (int) $request->query('periode', 2026);
        abort_if($nik === '', 422, 'NIK wajib diisi.');

        $penduduk = DB::table('d_penduduk_2026')
            ->where('nik', $nik)
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$penduduk, 404, 'NIK tidak ditemukan di data penduduk.');

        return response()->json([
            'status' => 'success',
            'data'   => $penduduk,
        ]);
    }

    public function storeDetail(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer|min:1',
            'periode'       => 'nullable|integer',
            'no_kk'         => 'nullable|string|max:30',
            'nik'           => 'required|string|max:20',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'rt'            => 'nullable|string|max:10',
            'rw'            => 'nullable|string|max:10',
            'alamat'        => 'nullable|string',
        ]);

        $periode = (int) ($validated['periode'] ?? 2026);

        abort_unless(
            $this->wilayahValid($validated['id_kec'], $validated['id_kel']),
            422,
            'Kelurahan tidak sesuai dengan kecamatan.'
        );

        $this->cekAksesWilayah((int) $validated['id_kec'], (int) $validated['id_kel']);

        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', self::TABEL)
            ->where('jenis_form', 2)
            ->whereNotIn('alias', self::GKSTB_ALIASES)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator Pokja 4 tidak valid.');

        $duplikat = DB::table('d_pokja_4_detail_2026')
            ->where('id_pertanyaan', $validated['id_pertanyaan'])
            ->where('id_kel', $validated['id_kel'])
            ->where('periode', $periode)
            ->where('nik', $validated['nik'])
            ->whereNull('deleted_at')
            ->exists();

        abort_if($duplikat, 422, 'NIK sudah terdaftar pada indikator ini.');

        DB::table('d_pokja_4_detail_2026')->insert([
            'id_pertanyaan' => $validated['id_pertanyaan'],
            'id_kec'        => $validated['id_kec'],
            'id_kel'        => $validated['id_kel'],
            'periode'       => $periode,
            'no_kk'         => $validated['no_kk'] ?? null,
            'nik'           => $validated['nik'],
            'nama'          => strtoupper($validated['nama']),
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'rt'            => $validated['rt'] ?? null,
            'rw'            => $validated['rw'] ?? null,
            'alamat'        => $validated['alamat'] ?? null,
            'created_by'    => auth()->id(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil ditambahkan.',
        ]);
    }

    public function updateDetail(Request $request, int $id)
    {
        $row = DB::table('d_pokja_4_detail_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$row, 404, 'Data tidak ditemukan.');

        $this->cekAksesWilayah((int) $row->id_kec, (int) $row->id_kel);

        $validated = $request->validate([
            'no_kk'         => 'nullable|string|max:30',
            'nik'           => 'required|string|max:20',
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'rt'            => 'nullable|string|max:10',
            'rw'            => 'nullable|string|max:10',
            'alamat'        => 'nullable|string',
        ]);

        $duplikat = DB::table('d_pokja_4_detail_2026')
            ->where('id_pertanyaan', $row->id_pertanyaan)
            ->where('id_kel', $row->id_kel)
            ->where('periode', $row->periode)
            ->where('nik', $validated['nik'])
            ->where('id', '!=', $id)
            ->whereNull('deleted_at')
            ->exists();

        abort_if($duplikat, 422, 'NIK sudah terdaftar pada indikator ini.');

        DB::table('d_pokja_4_detail_2026')
            ->where('id', $id)
            ->update([
                'no_kk'         => $validated['no_kk'] ?? null,
                'nik'           => $validated['nik'],
                'nama'          => strtoupper($validated['nama']),
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'rt'            => $validated['rt'] ?? null,
                'rw'            => $validated['rw'] ?? null,
                'alamat'        => $validated['alamat'] ?? null,
                'updated_by'    => auth()->id(),
                'updated_at'    => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ]);
    }

    public function destroyDetail(int $id)
    {
        $row = DB::table('d_pokja_4_detail_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$row, 404, 'Data tidak ditemukan.');

        $this->cekAksesWilayah((int) $row->id_kec, (int) $row->id_kel);

        DB::table('d_pokja_4_detail_2026')
            ->where('id', $id)
            ->update([
                'deleted_by' => auth()->id(),
                'deleted_at' => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dihapus.',
        ]);
    }

    public function storeGkstb(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer|min:1',
            'periode'       => 'nullable|integer',
            'nama_proyek'   => 'required|string|max:255',
            'kategori'      => 'required|array|min:1',
            'kategori.*'    => 'required|string|max:150',
        ]);

        $periode = (int) ($validated['periode'] ?? 2026);

        abort_unless(
            $this->wilayahValid($validated['id_kec'], $validated['id_kel']),
            422,
            'Kelurahan tidak sesuai dengan kecamatan.'
        );

        $this->cekAksesWilayah((int) $validated['id_kec'], (int) $validated['id_kel']);

        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', self::TABEL)
            ->whereIn('alias', self::GKSTB_ALIASES)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator GKSTTB tidak valid.');

        DB::table('d_gkstb_2026')->insert([
            'id_pertanyaan' => $validated['id_pertanyaan'],
            'id_kec'        => $validated['id_kec'],
            'id_kel'        => $validated['id_kel'],
            'periode'       => $periode,
            'nama_proyek'   => $validated['nama_proyek'],
            'kategori'      => json_encode(array_values($validated['kategori']), JSON_UNESCAPED_UNICODE),
            'created_by'    => auth()->id(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data GKSTTB berhasil ditambahkan.',
        ]);
    }

    public function updateGkstb(Request $request, int $id)
    {
        $row = DB::table('d_gkstb_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$row, 404, 'Data GKSTTB tidak ditemukan.');

        $this->cekAksesWilayah((int) $row->id_kec, (int) $row->id_kel);

        $validated = $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'kategori'    => 'required|array|min:1',
            'kategori.*'  => 'required|string|max:150',
        ]);

        DB::table('d_gkstb_2026')
            ->where('id', $id)
            ->update([
                'nama_proyek' => $validated['nama_proyek'],
                'kategori'    => json_encode(array_values($validated['kategori']), JSON_UNESCAPED_UNICODE),
                'updated_by'  => auth()->id(),
                'updated_at'  => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data GKSTTB berhasil diperbarui.',
        ]);
    }

    public function destroyGkstb(int $id)
    {
        $row = DB::table('d_gkstb_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$row, 404, 'Data GKSTTB tidak ditemukan.');

        $this->cekAksesWilayah((int) $row->id_kec, (int) $row->id_kel);

        DB::table('d_gkstb_2026')
            ->where('id', $id)
            ->update([
                'deleted_by' => auth()->id(),
                'deleted_at' => now(),
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data GKSTTB berhasil dihapus.',
        ]);
    }

    private function wilayahValid(int $idKec, int $idKel): bool
    {
        $kecCol = collect(['id_kec', 'kecamatan_id', 'id_kecamatan', 'kode_kec'])
            ->first(fn ($col) => Schema::hasColumn('m_kelurahan', $col));

        return DB::table('m_kelurahan')
            ->where('id_kel', $idKel)
            ->when($kecCol, fn ($q) => $q->where($kecCol, $idKec))
            ->exists()
            && DB::table('m_kecamatan')->where('id_kec', $idKec)->exists();
    }

   private function cekAksesWilayah(int $idKec, int $idKel): void
    {
        $user = auth()->user();
        abort_if(!$user, 401, 'Unauthenticated.');

        abort_if(empty($user->id_kel), 403, 'Input data Pokja 4 hanya dapat dilakukan oleh user tingkat kelurahan.');
        abort_if((int) $user->id_kel !== $idKel, 403, 'Anda tidak memiliki hak akses untuk kelurahan ini.');

        if (!empty($user->id_kec)) {
            abort_if((int) $user->id_kec !== $idKec, 403, 'Anda tidak memiliki hak akses untuk kecamatan ini.');
        }
    }
}