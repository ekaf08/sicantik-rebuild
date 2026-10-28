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
        Schema::create('surabaya_emas_balita', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->unique();
            $table->string('nama_balita', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat_domisili');
            $table->string('kelurahan_domisili', 100);
            $table->string('kecamatan_domisili', 100);
            $table->string('tpk', 50)->nullable();
            $table->year('tahun');
            $table->timestamps();
        });

        Schema::create('surabaya_emas_riwayat_timbang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')
                  ->constrained('surabaya_emas_balita')
                  ->onDelete('cascade');
            $table->date('tanggal_timbang');
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('lila', 5, 2)->nullable();
            $table->string('tbu', 50)->nullable();
            $table->string('bbu', 50)->nullable();
            $table->string('bbtb', 50)->nullable();
            $table->string('status_gizi', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surabaya_emas_riwayat_timbang');
        Schema::dropIfExists('surabaya_emas_balita');
    }
};