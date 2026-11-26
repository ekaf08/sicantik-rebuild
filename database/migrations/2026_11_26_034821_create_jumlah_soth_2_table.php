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
        Schema::create('jumlah_soth_2', function (Blueprint $table) {
            $table->id();
            $table->string('nama_soth', 255)->nullable();
            $table->string('alamat_soth', 255)->nullable();
            $table->integer('rt_soth')->nullable();
            $table->integer('rw_soth')->nullable();
            $table->integer('id_kel')->nullable()->index();
            $table->string('nama_kel', 255)->nullable();
            $table->integer('id_kec')->nullable()->index();
            $table->string('nama_kec', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_soth_2');
    }
};
