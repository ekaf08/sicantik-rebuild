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
        Schema::create('m_detail_warga_belajar_b', function (Blueprint $table) {
            $table->integer('id_kel')->nullable();
            $table->string('kel', 255)->nullable();
            $table->integer('id_kec')->nullable();
            $table->string('lembaga', 255)->nullable();
            $table->integer('id_kelompok')->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('tgl_lahir', 255)->nullable();
            $table->string('jenis_kelamin', 255)->nullable();
            $table->string('nik', 255)->nullable();
            $table->string('no_kk', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('rt', 255)->nullable();
            $table->string('rw', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_detail_warga_belajar_b');
    }
};
