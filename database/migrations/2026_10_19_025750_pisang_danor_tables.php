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
        // 1. Tabel Anorganik (Pisang BSI)
        Schema::create('pisang_bsi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bsi');
            $table->string('alamat_bsi');
            $table->string('metode_pengolahan');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rw', 10);
            $table->string('rt', 10);
            $table->string('upload_file_1')->nullable();
            $table->string('upload_file_2')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Organik (Pisang Organik)
        Schema::create('pisang_organik', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rw', 10)->nullable();
            $table->string('rt', 10)->nullable();
            $table->decimal('jumlah_tonase', 10, 2)->default(0);
            $table->decimal('tonase_residu', 10, 2)->default(0);
            $table->decimal('sampah_terolah_anorganik', 10, 2)->nullable()->default(0);
            $table->decimal('sampah_terolah_organik', 10, 2)->nullable()->default(0);
            $table->json('metode_pengolahan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pisang_organik');
        Schema::dropIfExists('pisang_bsi');
    }
};
