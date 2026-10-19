<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('makan_ketan', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('nama_dasa_wisma');
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->integer('jumlah_rumah')->nullable();
            $table->string('tahun', 4);
            $table->string('juara')->nullable();
            $table->string('foto_1')->nullable();
            $table->string('foto_2')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('makan_ketan');
    }
};
