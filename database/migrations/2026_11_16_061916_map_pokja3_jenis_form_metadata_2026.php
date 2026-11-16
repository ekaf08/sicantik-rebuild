<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Mapping indikator Pokja 3 (`d_pokja_3_2026`). Kolom `alias` = nama kolom fisik di tabel.
     * Rentang ID 80-96 (ID 72-79 milik Pokja 1, 97-100 milik Pokja 4).
     *
     * - `jenis_form = 0` (Modal Daftar Kader, is_kader = true, is_tarik = true):
     *   ID 80 (kader_pangan), 81 (kader_sandang), 82 (kader_tata_laksana_rt).
     *   Sumber detail: `d_kader_2026` dengan filter `jenis_kader = alias`.
     *
     * - `jenis_form = 2` (Form Input / Direct Update Agregat, is_kader = false):
     *   ID 83-84 (Makanan Pokok), ID 85-88 & 90-91 (Pekarangan non-TOGA),
     *   ID 92-94 (Industri Rumah Tangga), ID 95-96 (Rumah Sehat / Tidak Sehat Layak).
     *   Target update langsung ke kolom `alias` pada `d_pokja_3_2026`.
     *
     * - `jenis_form = 3` (Modal Rincian Read-Only, is_kader = false, is_tarik = false):
     *   ID 89 (memanfaatkan_toga). Sumber: `d_toga_2026` lewat `query_detail`.
     *   Angka rekap dihitung dari d_toga_2026, bukan dari kolom `toga`.
     */
    public function up(): void
    {
        // unprepared: query_detail berisi :kec, :kel, :periode yang tidak boleh dianggap placeholder PDO
        DB::unprepared(<<<'SQL'
            INSERT INTO "public"."m_pertanyaan_dashboard_2026"
            ("id", "nama_pertanyaan", "tb_dashboard", "alias", "urutan", "is_kader", "is_tarik", "is_disable", "jenis_form", "value_param", "query_detail", "created_at")
            VALUES
            -- [jenis_form = 0] Jumlah Kader Pokja 3
            (80, 'jumlah_kader_pangan', 'd_pokja_3_2026', 'kader_pangan', 3, true, true, false, 0, '80', NULL, NOW()),
            (81, 'jumlah_kader_sandang', 'd_pokja_3_2026', 'kader_sandang', 4, true, true, false, 0, '81', NULL, NOW()),
            (82, 'jumlah_kader_tata_laksana_rumah_tangga', 'd_pokja_3_2026', 'kader_tata_laksana_rt', 5, true, true, false, 0, '82', NULL, NOW()),

            -- [jenis_form = 2] Pangan - Makanan Pokok
            (83, 'pangan_makanan_pokok_beras', 'd_pokja_3_2026', 'makanan_beras', 6, false, false, false, 2, NULL, NULL, NOW()),
            (84, 'pangan_makanan_pokok_non_beras', 'd_pokja_3_2026', 'makanan_non_beras', 7, false, false, false, 2, NULL, NULL, NOW()),

            -- [jenis_form = 2] Pangan - Pemanfaatan Pekarangan
            (85, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_peternakan', 'd_pokja_3_2026', 'peternakan', 8, false, false, false, 2, NULL, NULL, NOW()),
            (86, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_perikanan', 'd_pokja_3_2026', 'perikanan', 9, false, false, false, 2, NULL, NULL, NOW()),
            (87, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_warung_hidup', 'd_pokja_3_2026', 'warung_hidup', 10, false, false, false, 2, NULL, NULL, NOW()),
            (88, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_lumbung_hidup', 'd_pokja_3_2026', 'lumbung_hidup', 11, false, false, false, 2, NULL, NULL, NOW()),

            -- [jenis_form = 3] Pangan - Pemanfaatan Pekarangan (TOGA - Read-Only DataTables)
            (89, 'memanfaatkan_toga', 'd_pokja_3_2026', 'toga', 12, false, false, false, 3, 'Ya', $QUERY$
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

            -- [jenis_form = 2] Lanjutan Pekarangan, Industri Rumah Tangga, & Rumah
            (90, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_tanaman_keras', 'd_pokja_3_2026', 'tanaman_keras', 13, false, false, false, 2, NULL, NULL, NOW()),
            (91, 'pangan_pemanfaatan_pekarangan_hatinya_pkk_tanaman_lainnya', 'd_pokja_3_2026', 'tanaman_lainnya', 14, false, false, false, 2, NULL, NULL, NOW()),
            (92, 'jumlah_industri_rumah_tangga_pangan', 'd_pokja_3_2026', 'industri_pangan', 15, false, false, false, 2, NULL, NULL, NOW()),
            (93, 'jumlah_industri_rumah_tangga_sandang', 'd_pokja_3_2026', 'industri_sandang', 16, false, false, false, 2, NULL, NULL, NOW()),
            (94, 'jumlah_industri_rumah_tangga_jasa', 'd_pokja_3_2026', 'industri_jasa', 17, false, false, false, 2, NULL, NULL, NOW()),
            (95, 'total_rumah_sehat', 'd_pokja_3_2026', 'rumah_sehat_layak', 18, false, false, false, 2, 'Rumah Sehat', NULL, NOW()),
            (96, 'total_rumah_tidak_sehat', 'd_pokja_3_2026', 'rumah_tidak_sehat_layak', 19, false, false, false, 2, 'Rumah Tidak Sehat', NULL, NOW())

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
                "query_detail"    = EXCLUDED."query_detail";
        SQL);

        // Insert dengan ID eksplisit tidak menggeser sequence; samakan (dilewati jika id tanpa sequence)
        DB::unprepared(<<<'SQL'
            SELECT setval(
                pg_get_serial_sequence('public.m_pertanyaan_dashboard_2026', 'id'),
                (SELECT MAX("id") FROM "public"."m_pertanyaan_dashboard_2026")
            )
            WHERE pg_get_serial_sequence('public.m_pertanyaan_dashboard_2026', 'id') IS NOT NULL;
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
              AND "id" BETWEEN 80 AND 96
        ');
    }
};