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
            $table->text('mpasi_foto')->nullable;
            $table->text('url_video')->nullable;
            $table->timestamps();
            $table->integer('created_by');
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
