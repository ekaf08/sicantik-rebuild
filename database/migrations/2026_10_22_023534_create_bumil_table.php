<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bumil')) {
            return;
        }

        Schema::create('bumil', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 10)->default('hamil');   // hamil / nifas
            $table->string('no_kk', 20)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('nama');
            $table->unsignedSmallInteger('usia')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kecamatan');
            $table->string('kelurahan')->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('status_kek', 20)->nullable();       // KEK / Tidak KEK
            $table->boolean('resti')->default(false);           // ibu hamil risiko tinggi
            $table->date('tanggal')->nullable();                // tanggal pendataan
            $table->timestamps();
            $table->softDeletes();

            $table->index(['kategori', 'kecamatan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bumil');
    }
};
