<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_detail_paud_perkelurahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kec')->nullable()->index();
            $table->unsignedBigInteger('id_kel')->nullable()->index();
            $table->string('kelurahan', 150)->nullable();
            $table->string('nama');
            $table->string('jenjang', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_detail_paud_perkelurahan');
    }
};