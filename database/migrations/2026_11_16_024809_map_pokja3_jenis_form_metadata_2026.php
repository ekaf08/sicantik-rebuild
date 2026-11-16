<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Dokumentasi Mapping Indikator Pokja 3 (`d_pokja_3_2026`) berdasarkan `jenis_form`:
     *
     * - `jenis_form = 0` (Modal Daftar Kader, `is_kader = true`, `is_tarik = true`):
     *   ID 72 (Kader Pangan), ID 73 (Kader Sandang), ID 74 (Kader Tata Laksana RT).
     *   Sumber detail: `d_kader_2026` dengan filter `jenis_kader = alias`.
     *
     * - `jenis_form = 2` (Form Input / Direct Update Agregat, `is_kader = false`):
     *   ID 75-76 (Makanan Pokok), ID 77-80, 82, 181 (Pekarangan non-TOGA),
     *   ID 83-85 (Industri Rumah Tangga), ID 86-87 (Jumlah Rumah).
     *   Target update langsung ke kolom `alias` pada `d_pokja_3_2026`.
     *
     * - `jenis_form = 3` (Modal Rincian Transaksi Read-Only, `is_kader = false`, `is_tarik = false`):
     *   ID 81 (`memanfaatkan_toga`).
     *   Sumber detail: `d_toga_2026` melalui `query_detail` (tanpa tombol Tambah Data).
     */
    public function up(): void
    {
        DB::statement(<<<'SQL'
            INSERT INTO "public"."m_pertanyaan_dashboard_2026"
            ("id", "nama_pertanyaan", "tb_dashboard", "alias", "urutan", "is_kader", "is_tarik", "is_disable", "jenis_form", "value_param", "query_detail", "created_at")
            VALUES
            -- [jenis_form = 0] Jumlah Kader Pokja 3
            (80, 'jumlah_kader_pangan', 'd_pokja_3_2026', 'jumlah_kader_pangan', 3, true, true, false, 0, '72', NULL, NOW()),
            (81, 'jumlah_kader_sandang', 'd_pokja_3_2026', 'jumlah_kader_sandang', 4, true, true, false, 0, '73', NULL, NOW()),
            (82, 'jumlah_kader_tata_laksana_rumah_tangga', 'd_pokja_3_2026', 'jumlah_kader_tata_laksana_rumah_tangga', 5, true, true, false, 0, '74', NULL, NOW()),

            -- [jenis_form = 2] Pangan - Makanan Pokok
            (83, 'pangan_makanan_pokok_beras', 'd_pokja_3_2026', 'pangan_makanan_pokok_beras', 6, false, false, false, 2, NULL, NULL, NOW()),
            (84, 'pangan_makanan_pokok_non_beras', 'd_pokja_3_2026', 'pangan_makanan_pokok_non_beras', 7, false, false, false, 2, NULL, NULL, NOW()),

            -- [jenis_form = 2] Pangan - Pemanfaatan Pekarangan
            (85, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_peternakan', 'd_pokja_3_2026', 'pangan_pemanfaatan_pekarangan_hatinya_pkk_peternakan', 8, false, false, false, 2, NULL, NULL, NOW()),
            (86, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_perikanan', 'd_pokja_3_2026', 'pangan_pemanfaatan_pekarangan_hatinya_pkk_perikanan', 9, false, false, false, 2, NULL, NULL, NOW()),
            (87, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_warung_hidup', 'd_pokja_3_2026', 'pangan_pemanfaatan_pekarangan_hatinya_pkk_warung_hidup', 10, false, false, false, 2, NULL, NULL, NOW()),
            (88, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_lumbung_hidup', 'd_pokja_3_2026', 'pangan_pemanfaatan_pekarangan_hatinya_pkk_lumbung_hidup', 11, false, false, false, 2, NULL, NULL, NOW()),
            -- [jenis_form = 3] Pangan - Pemanfaatan Pekarangan (TOGA - Read-Only DataTables)
            (89, 'memanfaatkan_toga', 'd_pokja_3_2026', 'memanfaatkan_toga', 12, false, false, false, 3, 'Ya', $QUERY$
                SELECT
                    t.no_kk AS "NO KK",
                    t.nama_kepala_keluarga AS "NAMA KEPALA KELUARGA",
                    COALESCE(t.alamat, '') AS "ALAMAT",
                    COALESCE(t.rt, '') AS "RT",
                    COALESCE(t.rw, '') AS "RW",
                    kc.nama_kec AS "KECAMATAN",
                    kl.nama_kel AS "KELURAHAN",
                    t.nama_jawaban AS "NAMA JAWABAN"
                FROM d_toga_2026 t
                LEFT JOIN m_kecamatan kc ON kc.id_kec = t.id_kec
                LEFT JOIN m_kelurahan kl ON kl.id_kel = t.id_kel
                WHERE t.id_kec = :kec
                  AND (:kel = 0 OR t.id_kel = :kel)
                  AND t.periode = :periode
                  AND t.nama_jawaban = 'Ya'
                  AND t.deleted_at IS NULL
                ORDER BY t.id ASC
            $QUERY$, NOW()),

            -- [jenis_form = 2] Lanjutan Pekarangan, Industri Rumah Tangga, & Jumlah Rumah
            (90, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_tanaman_keras', 'd_pokja_3_2026', 'pangan_pemanfaatan_pekarangan_hatinya_pkk_tanaman_keras', 13, false, false, false, 2, NULL, NULL, NOW()),
            (91, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_tanaman_lainnya', 'd_pokja_3_2026', 'pangan_pemanfaatan_pekarangan_hatinya_pkk_tanaman_lainnya', 14, false, false, false, 2, NULL, NULL, NOW()),
            (92, 'jumlah_industri_rumah_tangga_pangan', 'd_pokja_3_2026', 'jumlah_industri_rumah_tangga_pangan', 15, false, false, false, 2, NULL, NULL, NOW()),
            (93, 'jumlah_industri_rumah_tangga_sandang', 'd_pokja_3_2026', 'jumlah_industri_rumah_tangga_sandang', 16, false, false, false, 2, NULL, NULL, NOW()),
            (94, 'jumlah_industri_rumah_tangga_jasa', 'd_pokja_3_2026', 'jumlah_industri_rumah_tangga_jasa', 17, false, false, false, 2, NULL, NULL, NOW()),
            (95, 'total_rumah_sehat', 'd_pokja_3_2026', 'total_rumah_sehat', 18, false, false, false, 2, 'Rumah Sehat', NULL, NOW()),
            (96, 'total_rumah_tidak_sehat', 'd_pokja_3_2026', 'total_rumah_tidak_sehat', 19, false, false, false, 2, 'Rumah Tidak Sehat', NULL, NOW())

            ON CONFLICT ("id") DO UPDATE SET
                "nama_pertanyaan" = EXCLUDED."nama_pertanyaan",
                "tb_dashboard"    = EXCLUDED."tb_dashboard",
                "alias"           = EXCLUDED."alias",
                "urutan"          = EXCLUDED."urutan",
                "is_kader"        = EXCLUDED."is_kader",
                "is_tarik"        = EXCLUDED."is_tarik",
                "is_disable"      = EXCLUDED."is_disable",
                "jenis_form"      = EXCLUDED."jenis_form",
                "value_param"     = EXCLUDED."value_param",
                "query_detail"    = EXCLUDED."query_detail"
        SQL);
    }

    /**
     * Hapus mapping metadata Pokja 3 saat rollback.
     */
    public function down(): void
    {
        DB::statement('
            DELETE FROM "public"."m_pertanyaan_dashboard_2026"
            WHERE "tb_dashboard" = \'d_pokja_3_2026\'
              AND "id" IN (80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96)
        ');
    }
};