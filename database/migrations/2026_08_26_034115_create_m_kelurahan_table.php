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
        Schema::create('m_kelurahan', function (Blueprint $table) {
            $table->id('id_kel'); // int4 (PK)

            $table->string('nama_kel');
            $table->string('no_kab')->nullable();
            $table->string('no_prop')->nullable();
            $table->integer('no_kec')->nullable(); // int4
            $table->string('kode_kec_bpjs')->nullable();
            $table->string('kode_kel_bpjs')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('kode_faskes')->nullable();
            $table->string('no_puskesmas')->nullable();
            $table->string('nama_puskesmas')->nullable();
            $table->string('new_nama_kel')->nullable();
            $table->string('nama_kel_nas')->nullable();
            $table->bigInteger('id_kel_pemerintahan')->nullable(); // int8
            $table->bigInteger('id_kel_sitomas')->nullable();      // int8
            $table->bigInteger('id_kel_dispusip')->nullable();     // int8
            $table->string('kel_sibasam')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kelurahan');
    }
};
