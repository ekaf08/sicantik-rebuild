<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Pokja4Controller extends Controller
{
    private const TABEL = 'd_pokja_4_2026';

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

        abort_unless(
            $this->wilayahValid($validated['id_kec'], $validated['id_kel']),
            422,
            'Kelurahan tidak sesuai dengan kecamatan.'
        );

        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', self::TABEL)
            ->where(fn ($q) => $q->whereNull('is_kader')->orWhere('is_kader', false))
            ->whereIn('jenis_form', [1, 2])
            ->where(fn ($q) => $q->whereNull('is_disable')->orWhere('is_disable', false))
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator Pokja 4 tidak valid.');

        $kolom = $pertanyaan->alias;
        abort_unless(Schema::hasColumn(self::TABEL, $kolom), 422, 'Kolom target tidak ditemukan.');

        $key  = ['id_kec' => $validated['id_kec'], 'id_kel' => $validated['id_kel'], 'periode' => $periode];
        $nilai = [$kolom => $validated['nilai']];

        $updated = DB::table(self::TABEL)->where($key)->update($nilai + ['updated_at' => now()]);

        if (!$updated) {
            DB::table(self::TABEL)->insert($key + $nilai + [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ]);
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