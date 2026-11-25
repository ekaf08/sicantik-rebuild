<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const QUERY = <<<'SQL'
SELECT d.nama_posyandu AS "NAME", COALESCE(d.rt, '') AS "RT", COALESCE(d.rw, '') AS "RW",
       k.nama_kel AS "KELURAHAN", c.nama_kec AS "KECAMATAN"
FROM d_posyandu_2026 d
JOIN m_kelurahan k ON k.id_kel = d.id_kel
JOIN m_kecamatan c ON c.id_kec = d.id_kec
WHERE d.id_kec = :kec AND (:kel = 0 OR d.id_kel = :kel)
  AND d.periode = :periode AND d.deleted_at IS NULL
ORDER BY k.nama_kel, LPAD(COALESCE(d.rw, ''), 3, '0'), LPAD(COALESCE(d.rt, ''), 3, '0')
SQL;

    public function up(): void
    {
        Schema::create('d_posyandu_2026', function (Blueprint $t) {
            $t->id();
            $t->integer('id_kec');
            $t->integer('id_kel');
            $t->smallInteger('periode')->default(2026);
            $t->string('nama_posyandu');
            $t->string('rw', 10)->nullable();
            $t->string('rt', 10)->nullable();
            $t->unsignedBigInteger('created_by')->nullable();
            $t->unsignedBigInteger('deleted_by')->nullable();
            $t->timestamps();
            $t->timestamp('deleted_at')->nullable();
            $t->index(['id_kec', 'id_kel', 'periode']);
        });

        // satu posyandu mencakup satu RT hanya sekali per kelurahan per periode
        DB::statement("CREATE UNIQUE INDEX d_posyandu_2026_uq
            ON d_posyandu_2026 (id_kel, periode, nama_posyandu, COALESCE(rw, ''), COALESCE(rt, ''))
            WHERE deleted_at IS NULL");

        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')->where('alias', 'posyandu')
            ->update(['jenis_form' => 0, 'is_kader' => false, 'query_detail' => self::QUERY]);
    }

    public function down(): void
    {
        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')->where('alias', 'posyandu')
            ->update(['query_detail' => null]);

        Schema::dropIfExists('d_posyandu_2026');
    }
};