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
        Schema::create('ibu_hamil_resiko', function (Blueprint $table) {
            // Tidak ada primary key (id) di skema asli, 
            // jadi kita tidak memanggil $table->id();

            $table->string('nokk', 50)->nullable();
            $table->string('nik', 50)->nullable();
            $table->string('namalengkap', 200)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('alamatktp', 255)->nullable();
            $table->string('rtktp', 10)->nullable();
            $table->string('rwktp', 10)->nullable();
            $table->string('kelurahanktp', 255)->nullable();
            $table->string('kecamatanktp', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('rt', 32)->nullable();
            $table->string('rw', 32)->nullable();
            $table->string('kelurahan', 255)->nullable();
            $table->string('kecamatan', 255)->nullable();
            $table->text('resiko')->nullable();
            $table->date('tanggalperkiraan')->nullable();
            $table->json('riwayat_kehamilan')->nullable();
            $table->json('riwayat_catin')->nullable();

            // Opsional: Jika Anda butuh kolom timestamps (created_at, updated_at)
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibu_hamil_resiko');
    }
};
