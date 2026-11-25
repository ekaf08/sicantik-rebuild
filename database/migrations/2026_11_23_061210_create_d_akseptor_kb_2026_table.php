<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function queryDetail(string $jk): string
    {
        return <<<SQL
SELECT COALESCE(d.no_kk, '') AS "NO KK",
       d.nik AS "NIK",
       d.nama AS "NAMA",
       d.tanggal_lahir AS "TANGGAL LAHIR",
       EXTRACT(YEAR FROM AGE(CURRENT_DATE, d.tanggal_lahir))::int AS "USIA",
       COALESCE(d.alamat, '') AS "ALAMAT",
       c.nama_kec AS "KECAMATAN",
       k.nama_kel AS "KELURAHAN",
       COALESCE(d.metode_kontrasepsi, '-') AS "METODE KONTRASEPSI",
       CASE
           WHEN d.jenis_kelamin = 'L' THEN 'LAKI-LAKI'
           WHEN d.jenis_kelamin = 'P' THEN 'PEREMPUAN'
           ELSE d.jenis_kelamin
       END AS "JENIS KELAMIN"
FROM d_akseptor_kb_2026 d
JOIN m_kelurahan k ON k.id_kel = d.id_kel
JOIN m_kecamatan c ON c.id_kec = d.id_kec
WHERE d.id_kec = :kec AND (:kel = 0 OR d.id_kel = :kel)
  AND d.periode = :periode AND d.deleted_at IS NULL
  AND d.jenis_kelamin = '{$jk}'
ORDER BY k.nama_kel, d.nama
SQL;
    }

    public function up(): void
    {
        Schema::create('d_akseptor_kb_2026', function (Blueprint $t) {
            $t->id();
            $t->integer('id_kec');
            $t->integer('id_kel');
            $t->smallInteger('periode')->default(2026);
            $t->string('no_kk', 30)->nullable();
            $t->string('nik', 20);
            $t->string('nama');
            $t->date('tanggal_lahir')->nullable();
            $t->text('alamat')->nullable();
            $t->string('metode_kontrasepsi', 100)->nullable();
            $t->string('jenis_kelamin', 1); // L atau P
            $t->unsignedBigInteger('created_by')->nullable();
            $t->unsignedBigInteger('updated_by')->nullable();
            $t->unsignedBigInteger('deleted_by')->nullable();
            $t->timestamps();
            $t->timestamp('deleted_at')->nullable();

            $t->index(['id_kec', 'id_kel', 'periode']);
        });

        DB::statement("CREATE UNIQUE INDEX d_akseptor_kb_2026_uq
            ON d_akseptor_kb_2026 (id_kel, periode, nik)
            WHERE deleted_at IS NULL");

        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->where('alias', 'akseptor_kb_l')
            ->update([
                'jenis_form'   => 0,
                'is_kader'     => false,
                'query_detail' => $this->queryDetail('L'),
            ]);

        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->where('alias', 'akseptor_kb_p')
            ->update([
                'jenis_form'   => 0,
                'is_kader'     => false,
                'query_detail' => $this->queryDetail('P'),
            ]);
    }

    public function down(): void
    {
        DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_4_2026')
            ->whereIn('alias', ['akseptor_kb_l', 'akseptor_kb_p'])
            ->update(['query_detail' => null]);

        Schema::dropIfExists('d_akseptor_kb_2026');
    }
};