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
        Schema::create('peserta_bkb', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kec')->nullable()->index();
            $table->unsignedBigInteger('id_kel')->nullable()->index();
            $table->string('nik', 20)->nullable();
            $table->string('nama');
            $table->string('nama_anak')->nullable();
            $table->string('kelurahan', 150)->nullable();
            $table->string('kecamatan', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_bkb');
    }
};
