<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('d_pokja_3_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->integer('id_kel')->nullable();
            $table->smallInteger('periode')->default(2026);

            // Jumlah Kader
            $table->unsignedInteger('kader_pangan')->default(0);
            $table->unsignedInteger('kader_sandang')->default(0);
            $table->unsignedInteger('kader_tata_laksana_rt')->default(0);

            // Pangan - Makanan Pokok
            $table->unsignedInteger('makanan_beras')->default(0);
            $table->unsignedInteger('makanan_non_beras')->default(0);

            // Pangan - Pemanfaatan Pekarangan
            $table->unsignedInteger('peternakan')->default(0);
            $table->unsignedInteger('perikanan')->default(0);
            $table->unsignedInteger('warung_hidup')->default(0);
            $table->unsignedInteger('lumbung_hidup')->default(0);
            $table->unsignedInteger('toga')->default(0);
            $table->unsignedInteger('tanaman_keras')->default(0);
            $table->unsignedInteger('tanaman_lainnya')->default(0);

            // Jumlah Industri Rumah Tangga
            $table->unsignedInteger('industri_pangan')->default(0);
            $table->unsignedInteger('industri_sandang')->default(0);
            $table->unsignedInteger('industri_jasa')->default(0);

            // Jumlah Rumah
            $table->unsignedInteger('rumah_sehat_layak')->default(0);
            $table->unsignedInteger('rumah_tidak_sehat_layak')->default(0);

            $table->timestamps();
        });

        DB::statement('CREATE UNIQUE INDEX d_pokja_3_2026_kec_uq ON d_pokja_3_2026 (id_kec, periode) WHERE id_kel IS NULL');
        DB::statement('CREATE UNIQUE INDEX d_pokja_3_2026_kel_uq ON d_pokja_3_2026 (id_kec, id_kel, periode) WHERE id_kel IS NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('d_pokja_3_2026');
    }
};