<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_lap_tahunan', function (Blueprint $table) {
            $table->id('id_lap_tahunan');
            $table->string('jenis_laporan', 50); 
            $table->string('tahun_periode', 4);
            $table->enum('level_wilayah', ['kota', 'kecamatan', 'kelurahan'])->default('kota');
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->unsignedBigInteger('id_kelurahan')->nullable();
            $table->string('file_kata_pengantar')->nullable();
            $table->string('file_bab_1')->nullable();
            $table->string('file_bab_2')->nullable();
            $table->string('file_bab_3')->nullable();
            $table->string('file_bab_4')->nullable();
            $table->string('file_bab_5')->nullable();
            $table->string('file_bab_6')->nullable();
            $table->string('file_bab_7')->nullable();
            $table->string('file_bab_8')->nullable();
            $table->string('file_full_laporan')->nullable();
            $table->string('file_memori_pj')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['jenis_laporan', 'tahun_periode', 'level_wilayah']);
        });
    }   

    public function down(): void
    {
        Schema::dropIfExists('t_lap_tahunan');
    }
};
