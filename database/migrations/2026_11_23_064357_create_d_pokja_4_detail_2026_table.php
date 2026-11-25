<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const ALIASES = [
        'imunisasi',
        'pkg',
        'tbc',
        'kesehatan',
        'kelestarian_lh',
        'perencanaan_sehat',
    ];

    private const QUERY_DETAIL = <<<'SQL'
SELECT d.id AS "id",
       COALESCE(d.no_kk, '') AS "NO KK",
       d.nik AS "NIK",
       d.nama AS "NAMA",
       CASE
           WHEN d.jenis_kelamin = 'L' THEN 'LAKI-LAKI'
           WHEN d.jenis_kelamin = 'P' THEN 'PEREMPUAN'
           ELSE COALESCE(d.jenis_kelamin, '-')
       END AS "JENIS KELAMIN",
       COALESCE(d.rt, '') AS "RT",
       COALESCE(d.rw, '') AS "RW",
       COALESCE(d.alamat, '') AS "ALAMAT"
FROM d_pokja_4_detail_2026 d
WHERE d.id_pertanyaan = :id_pertanyaan
  AND d.id_kec = :kec
  AND (:kel = 0 OR d.id_kel = :kel)
  AND d.periode = :periode
  AND d.deleted_at IS NULL
ORDER BY d.id DESC
SQL;

    public function up(): void
    {
        Schema::create('d_pokja_4_detail_2026', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('id_pertanyaan');
            $t->integer('id_kec');
            $t->integer('id_kel');
            $t->smallInteger('periode')->default(2026);
            $t->string('no_kk', 30)->nullable();
            $t->string('nik', 20);
            $t->string('nama');
            $t->string('jenis_kelamin', 1); // L atau P
            $t->string('rt', 10)->nullable();
            $t->string('rw', 10)->nullable();
            $t->text('alamat')->nullable();
            $t->text('keterangan')->nullable();
            $t->unsignedBigInteger('created_by')->nullable();
            $t->unsignedBigInteger('updated_by')->nullable();
            $t->unsignedBigInteger('deleted_by')->nullable();
            $t->timestamps();
            $t->timestamp('deleted_at')->nullable();

            $t->index(['id_pertanyaan', 'id_kec', 'id_kel', 'periode']);
        });

        DB::statement("CREATE UNIQUE INDEX d_pokja_4_detail_2026_uq
            ON d_pokja_4_detail_2026 (id_pertanyaan, id_kel, periode, nik)
            WHERE deleted_at IS NULL");

        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->whereIn('alias', self::ALIASES)
            ->update([
                'jenis_form'   => 2,
                'is_kader'     => false,
                'query_detail' => self::QUERY_DETAIL,
            ]);
    }

    public function down(): void
    {
        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->whereIn('alias', self::ALIASES)
            ->update(['query_detail' => null]);

        Schema::dropIfExists('d_pokja_4_detail_2026');
    }
};