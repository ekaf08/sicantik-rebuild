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
        Schema::create('m_detail_kelompok_belajar_b', function (Blueprint $table) {
            $table->bigInteger('id_kelompok')->nullable();
            $table->string('lembaga', 255)->nullable();
            $table->integer('id_kel')->nullable();
            $table->string('kel', 255)->nullable();
            $table->integer('id_kec')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('rt_rw', 255)->nullable();
            $table->string('nama_petugas', 255)->nullable();
            $table->string('nik_petugas', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_detail_kelompok_belajar_b');
    }
};
