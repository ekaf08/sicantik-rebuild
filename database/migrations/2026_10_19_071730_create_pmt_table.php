<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pmt')) {
            return;
        }

        Schema::create('pmt', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->string('nama_balita');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 20);
            $table->string('alamat');
            $table->string('nama_orang_tua');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->unsignedSmallInteger('tahun');
            $table->string('putaran', 20);
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->index(['tahun', 'putaran']);
            $table->index(['kecamatan', 'kelurahan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pmt');
    }
};
