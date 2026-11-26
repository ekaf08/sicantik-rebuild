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
        Schema::create('kelompok_bkb', function (Blueprint $table) {
            $table->bigInteger('id')->nullable();
            $table->bigInteger('kecamatan_id')->nullable();
            $table->integer('id_kec')->nullable();
            $table->integer('id_kel')->nullable();
            $table->bigInteger('kelurahan_id')->nullable();
            $table->bigInteger('nomor_register')->nullable();
            $table->string('nama_kelompok', 255)->nullable();
            $table->string('alamat_jalan', 255)->nullable();
            $table->string('nama_pembina_pkbid', 255)->nullable();
            $table->string('nomor_sk', 255)->nullable();
            $table->string('mengetahui_pembina_nama', 255)->nullable();
            $table->string('mengetahui_ketua_nama', 255)->nullable();
            $table->decimal('label', 255, 0)->nullable();
            $table->string('nama_kel', 255)->nullable();
            $table->string('nama_kec', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_bkb');
    }
};
