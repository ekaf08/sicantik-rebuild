<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_kelompok_belajar_pokja2_kf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pertanyaan')->nullable()->index();
            $table->unsignedBigInteger('id_kec')->index();
            $table->unsignedBigInteger('id_kel')->index();
            $table->integer('periode')->default(2026)->index();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('jenis_keterampilan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('m_warga_belajar_pokja2_kf', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pertanyaan')->nullable()->index();
            $table->unsignedBigInteger('id_kec')->index();
            $table->unsignedBigInteger('id_kel')->index();
            $table->integer('periode')->default(2026)->index();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('jenis_keterampilan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_warga_belajar_pokja2_kf');
        Schema::dropIfExists('m_kelompok_belajar_pokja2_kf');
    }
};