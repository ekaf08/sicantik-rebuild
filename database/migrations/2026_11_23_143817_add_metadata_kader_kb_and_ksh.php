<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Dokumentasi kustomisasi kolom modal read-only (`query_detail`) untuk Kader Pokja 4:
     * 1. `kb`: menampilkan NIK, NAMA, ALAMAT DOMISILI, KECAMATAN, KELURAHAN.
     * 2. `kader_sby_hebat`: menampilkan NIK, NAMA KADER, ROLE, JENIS KELAMIN, KECAMATAN, KELURAHAN.
     * 3. 4 indikator kader Pokja 4 lainnya (`kader_kesehatan`, `gizi`, `kesling`, `phbs`)
     *    tetap dibiarkan `query_detail = NULL` agar memakai susunan kolom standar kader.
     */
    public function up(): void
    {
        // 1. Kader KB (alias = 'kb')
        DB::statement(<<<'SQL'
            UPDATE "public"."m_pertanyaan_dashboard_2026"
            SET
                "is_kader"     = true,
                "is_tarik"     = false,
                "jenis_form"   = 0,
                "query_detail" = $QUERY$
                    SELECT
                        k.nik AS "NIK",
                        k.nama AS "NAMA",
                        COALESCE(k.alamat, '') AS "ALAMAT DOMISILI",
                        kc.nama_kec AS "KECAMATAN",
                        kl.nama_kel AS "KELURAHAN"
                    FROM d_kader_2026 k
                    LEFT JOIN m_kecamatan kc ON kc.id_kec = k.id_kec
                    LEFT JOIN m_kelurahan kl ON kl.id_kel = k.id_kel
                    WHERE k.id_kec = :kec
                      AND (:kel = 0 OR k.id_kel = :kel)
                      AND k.jenis_kader = 'kb'
                      AND k.periode = :periode
                      AND k.deleted_at IS NULL
                    ORDER BY k.nama ASC
                $QUERY$
            WHERE "tb_dashboard" = 'd_pokja_4_2026'
              AND "alias" = 'kb'
              AND "deleted_at" IS NULL
        SQL);

        // 2. Kader Surabaya Hebat (alias = 'kader_sby_hebat')
        DB::statement(<<<'SQL'
            UPDATE "public"."m_pertanyaan_dashboard_2026"
            SET
                "is_kader"     = true,
                "is_tarik"     = false,
                "jenis_form"   = 0,
                "query_detail" = $QUERY$
                    SELECT
                        k.nik AS "NIK",
                        k.nama AS "NAMA KADER",
                        LOWER(COALESCE(NULLIF(k.jabatan, ''), 'kader')) AS "ROLE",
                        CASE
                            WHEN UPPER(k.jenis_kelamin) = 'L' THEN 'LAKI-LAKI'
                            WHEN UPPER(k.jenis_kelamin) = 'P' THEN 'PEREMPUAN'
                            ELSE COALESCE(k.jenis_kelamin, '')
                        END AS "JENIS KELAMIN",
                        kc.nama_kec AS "KECAMATAN",
                        kl.nama_kel AS "KELURAHAN"
                    FROM d_kader_2026 k
                    LEFT JOIN m_kecamatan kc ON kc.id_kec = k.id_kec
                    LEFT JOIN m_kelurahan kl ON kl.id_kel = k.id_kel
                    WHERE k.id_kec = :kec
                      AND (:kel = 0 OR k.id_kel = :kel)
                      AND k.jenis_kader = 'kader_sby_hebat'
                      AND k.periode = :periode
                      AND k.deleted_at IS NULL
                    ORDER BY k.nama ASC
                $QUERY$
            WHERE "tb_dashboard" = 'd_pokja_4_2026'
              AND "alias" = 'kader_sby_hebat'
              AND "deleted_at" IS NULL
        SQL);
    }

    /**
     * Kembalikan `query_detail` ke NULL (susunan kolom kader standar) saat rollback.
     */
    public function down(): void
    {
        DB::statement(<<<'SQL'
            UPDATE "public"."m_pertanyaan_dashboard_2026"
            SET "query_detail" = NULL
            WHERE "tb_dashboard" = 'd_pokja_4_2026'
              AND "alias" IN ('kb', 'kader_sby_hebat')
              AND "deleted_at" IS NULL
        SQL);
    }
};