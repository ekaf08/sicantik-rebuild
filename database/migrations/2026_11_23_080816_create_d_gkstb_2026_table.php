<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const ALIASES = [
        'kesehatan',
        'kelestarian_lh',
        'perencanaan_sehat',
    ];

    private const QUERY_DETAIL = <<<'SQL'
SELECT d.id AS "id",
       d.nama_proyek AS "NAMA PROYEK",
       d.kategori AS "KATEGORI",
       k.nama_kel AS "KELURAHAN",
       c.nama_kec AS "KECAMATAN"
FROM d_gkstb_2026 d
JOIN m_kelurahan k ON k.id_kel = d.id_kel
JOIN m_kecamatan c ON c.id_kec = d.id_kec
WHERE d.id_pertanyaan = :id_pertanyaan
  AND d.id_kec = :kec
  AND (:kel = 0 OR d.id_kel = :kel)
  AND d.periode = :periode
  AND d.deleted_at IS NULL
ORDER BY d.id DESC
SQL;

    public function up(): void
    {
        Schema::create('d_gkstb_2026', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('id_pertanyaan');
            $t->integer('id_kec');
            $t->integer('id_kel');
            $t->smallInteger('periode')->default(2026);
            $t->string('nama_proyek');
            $t->text('kategori'); // JSON array checkbox
            $t->unsignedBigInteger('created_by')->nullable();
            $t->unsignedBigInteger('updated_by')->nullable();
            $t->unsignedBigInteger('deleted_by')->nullable();
            $t->timestamps();
            $t->timestamp('deleted_at')->nullable();

            $t->index(['id_pertanyaan', 'id_kec', 'id_kel', 'periode']);
        });

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

        Schema::dropIfExists('d_gkstb_2026');
    }
};