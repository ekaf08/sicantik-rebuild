<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_umum_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->smallInteger('periode')->default(2026);

            $table->unsignedInteger('desa')->default(0);
            $table->unsignedInteger('kelurahan')->default(0);
            $table->unsignedInteger('rw')->default(0);

            $table->unsignedInteger('dusun_lingkungan')->default(0);
            $table->unsignedInteger('pkk_rw')->default(0);
            $table->unsignedInteger('pkk_rt')->default(0);
            $table->unsignedInteger('dasa_wisma')->default(0);

            $table->unsignedInteger('krt')->default(0);
            $table->unsignedInteger('kk')->default(0);

            $table->unsignedInteger('jumlah_jiwa_l')->default(0);
            $table->unsignedInteger('jumlah_jiwa_p')->default(0);

            $table->unsignedInteger('anggota_tp_pkk_l')->default(0);
            $table->unsignedInteger('anggota_tp_pkk_p')->default(0);
            $table->unsignedInteger('umum_l')->default(0);
            $table->unsignedInteger('umum_p')->default(0);
            $table->unsignedInteger('khusus_l')->default(0);
            $table->unsignedInteger('khusus_p')->default(0);

            $table->unsignedInteger('honorer_l')->default(0);
            $table->unsignedInteger('honorer_p')->default(0);
            $table->unsignedInteger('bantuan_l')->default(0);
            $table->unsignedInteger('bantuan_p')->default(0);

            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['id_kec', 'periode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_umum_2026');
    }
};
