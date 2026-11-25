<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menyimpan isi foto di database bersama, supaya foto yang diupload satu orang
    // terlihat di semua laptop. Kolom `foto` di tabel lain tetap berisi path (mis. pmt/abc.jpg).
    public function up(): void
    {
        if (Schema::hasTable('berkas_foto')) {
            return;
        }

        Schema::create('berkas_foto', function (Blueprint $table) {
            $table->id();
            $table->string('path')->unique();
            $table->string('mime', 100);
            $table->longText('isi'); // base64
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_foto');
    }
};
