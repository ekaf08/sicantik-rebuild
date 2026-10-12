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
        Schema::create('t_mpasi', function (Blueprint $table) {
            $table->id('id_mpasi');
            $table->string('judul');
            $table->string('kategori_usia');
            $table->text('deskripsi')->nullable();
            $table->text('bahan');
            $table->text('langkah');
            $table->string('mpasi_foto')->nullable;
            $table->string('url_video')->nullable;
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_mpasi');
    }
};
