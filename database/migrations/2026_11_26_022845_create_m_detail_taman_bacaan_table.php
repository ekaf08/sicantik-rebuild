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
        Schema::create('m_detail_taman_bacaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kec')->nullable()->index();
            $table->unsignedBigInteger('id_kel')->nullable()->index();
            $table->string('nama_lokasi');
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('kecamatan', 150)->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('jml_koleksibukueksemplar', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_detail_taman_bacaan');
    }
};
