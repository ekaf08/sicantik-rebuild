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
        Schema::create('m_kecamatan', function (Blueprint $table) {
            $table->id('id_kec');
            $table->string('nama_kec');
            $table->string('no_kab')->nullable();
            $table->string('no_prop')->nullable();
            $table->string('kode_bpjs')->nullable();
            $table->string('id_wilayah')->nullable();
            $table->string('new_nama_kec')->nullable();
            $table->bigInteger('id_kec_pemerintahan')->nullable(); // int8
            $table->bigInteger('id_kec_sitomas')->nullable();      // int8
            $table->bigInteger('id_kec_dispusip')->nullable();     // int8
            $table->string('kec_sibasam')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kecamatan');
    }
};
