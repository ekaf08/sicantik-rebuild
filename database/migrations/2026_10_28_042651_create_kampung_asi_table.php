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
        Schema::create('kampung_asi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kec')->nullable()->index();
            $table->unsignedBigInteger('id_kel')->nullable()->index();
            $table->string('kecamatan', 100)->index();
            $table->string('kelurahan', 100)->index();
            $table->string('nama_kampung_asi', 150);
            $table->integer('jumlah_kader')->default(0);
            $table->integer('jumlah_toga')->default(0);
            $table->integer('ibu_hamil')->default(0);
            $table->integer('ibu_menyusui')->default(0);
            $table->decimal('persentase', 5, 2)->default(0.00);
            $table->year('tahun')->default(2026);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kampung_asi');
    }
};