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
        Schema::create('d_pokja_3_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->smallInteger('periode')->default(2026);

            //Jumlah Kader
            $table->unsignedBigInteger('kader_pangan')->default(0);      // Col 3
            $table->unsignedBigInteger('kader_sandang')->default(0);     // Col 4
            $table->unsignedBigInteger('kader_tlrt')->default(0);        // Col 5 (Tata Laksana Rumah Tangga)

            //Pangan->Makanan Pokok
            $table->unsignedBigInteger('pangan_beras')->default(0);      // Col 6
            $table->unsignedBigInteger('pangan_non_beras')->default(0);  // Col 7

            //Pangan->Pemanfaatan Pekarangan
            $table->unsignedBigInteger('pekarangan_peternakan')->default(0);     // Col 8
            $table->unsignedBigInteger('pekarangan_perikanan')->default(0);      // Col 9
            $table->unsignedBigInteger('pekarangan_warung_hidup')->default(0);   // Col 10
            $table->unsignedBigInteger('pekarangan_lumbung_hidup')->default(0);  // Col 11
            $table->unsignedBigInteger('pekarangan_toga')->default(0);           // Col 12
            $table->unsignedBigInteger('pekarangan_tanaman_keras')->default(0);   // Col 13
            $table->unsignedBigInteger('pekarangan_tanaman_lainnya')->default(0); // Col 14

            //Jumlah Industri Rumah Tangga
            $table->unsignedBigInteger('irt_pangan')->default(0);        // Col 15
            $table->unsignedBigInteger('irt_sandang')->default(0);       // Col 16
            $table->unsignedBigInteger('irt_jasa')->default(0);          // Col 17

            //Jumlah Rumah
            $table->unsignedBigInteger('rumah_sehat')->default(0);       // Col 18 (Sehat & Layak Huni)
            $table->unsignedBigInteger('rumah_tidak_sehat')->default(0);

            $table->timestamps();

            $table->unique(['id_kec', 'periode']);

            $table->unsignedBigInteger(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_pokja_3_2026');
    }
};
