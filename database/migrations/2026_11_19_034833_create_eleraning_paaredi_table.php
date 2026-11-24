<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_paaredi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kec')->nullable()->index();
            $table->unsignedBigInteger('id_kel')->nullable()->index();
            $table->string('kecamatan', 100)->index();
            $table->string('kelurahan', 100)->index();
            $table->string('nama_peserta', 150);
            $table->string('nik', 25);
            $table->string('materi', 255);
            $table->decimal('skor', 5, 2)->default(0.00);
            $table->integer('tahun')->default(2026);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_paaredi');
    }
};