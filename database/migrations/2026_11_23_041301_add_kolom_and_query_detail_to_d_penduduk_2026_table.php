<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const AGE_EXPR = <<<'SQL'
(
    EXTRACT(YEAR FROM CURRENT_DATE)::int -
    CASE
        WHEN SUBSTRING(p.nik, 11, 2)::int <= (EXTRACT(YEAR FROM CURRENT_DATE)::int % 100)
            THEN 2000 + SUBSTRING(p.nik, 11, 2)::int
        ELSE 1900 + SUBSTRING(p.nik, 11, 2)::int
    END
) BETWEEN 15 AND 49
SQL;

    public function up(): void
    {
        $age = self::AGE_EXPR;

        $queryWus = <<<SQL
SELECT d.nik AS "NIK",
       d.nama AS "NAMA",
       d.no_kk AS "NO KK",
       COALESCE(d.alamat, '') AS "ALAMAT",
       c.nama_kec AS "KECAMATAN",
       k.nama_kel AS "KELURAHAN"
FROM d_penduduk_2026 d
JOIN m_kelurahan k ON k.id_kel = d.id_kel
JOIN m_kecamatan c ON c.id_kec = d.id_kec
WHERE d.id_kec = :kec AND (:kel = 0 OR d.id_kel = :kel)
  AND d.periode = :periode AND d.deleted_at IS NULL
  AND d.jenis_kelamin = 'P'
  AND d.nik ~ '^[0-9]{16}$'
  AND {$this->replaceAlias($age, 'd')}
ORDER BY k.nama_kel, d.nama
SQL;

        $queryPus = <<<SQL
SELECT DISTINCT ON (d.no_kk)
       d.nik AS "NIK",
       d.nama AS "NAMA",
       d.no_kk AS "NO KK",
       COALESCE(d.alamat, '') AS "ALAMAT",
       c.nama_kec AS "KECAMATAN",
       k.nama_kel AS "KELURAHAN"
FROM d_penduduk_2026 d
JOIN m_kelurahan k ON k.id_kel = d.id_kel
JOIN m_kecamatan c ON c.id_kec = d.id_kec
WHERE d.id_kec = :kec AND (:kel = 0 OR d.id_kel = :kel)
  AND d.periode = :periode AND d.deleted_at IS NULL
  AND EXISTS (
      SELECT 1 FROM d_penduduk_2026 l
      WHERE l.no_kk = d.no_kk AND l.periode = d.periode AND l.deleted_at IS NULL
        AND l.jenis_kelamin = 'L'
  )
  AND EXISTS (
      SELECT 1 FROM d_penduduk_2026 p
      WHERE p.no_kk = d.no_kk AND p.periode = d.periode AND p.deleted_at IS NULL
        AND p.jenis_kelamin = 'P'
        AND p.nik ~ '^[0-9]{16}$'
        AND {$age}
  )
ORDER BY d.no_kk, d.kepala_keluarga DESC, d.id ASC
SQL;

        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->where('alias', 'jumlah_pus')
            ->update([
                'jenis_form'   => 0,
                'is_kader'     => false,
                'is_tarik'     => false,
                'query_detail' => $queryPus,
            ]);

        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->where('alias', 'jumlah_wus')
            ->update([
                'jenis_form'   => 0,
                'is_kader'     => false,
                'is_tarik'     => false,
                'query_detail' => $queryWus,
            ]);
    }

    public function down(): void
    {
        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->whereIn('alias', ['jumlah_pus', 'jumlah_wus'])
            ->update(['query_detail' => null]);
    }

    private function replaceAlias(string $sql, string $alias): string
    {
        return str_replace('p.nik', "{$alias}.nik", $sql);
    }
};