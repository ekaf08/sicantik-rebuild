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
        Schema::create('kisak_pokja1', function (Blueprint $table) {
            // int8 NOT NULL DEFAULT nextval(...) -> Big Integer Auto Increment
            $table->id();

            $table->date('tgl_kegiatan')->nullable();
            $table->string('tempat', 255)->nullable();
            $table->text('materi')->nullable();

            // int8 untuk id_kec dan id_kel
            $table->bigInteger('id_kec')->nullable();
            $table->bigInteger('id_kel')->nullable();

            // Timestamps
            $table->timestamps(); // Membuat created_at dan updated_at (timestamp)
            $table->softDeletes(); // Membuat deleted_at (timestamp)

            // int4 untuk pertanyaan_id
            $table->integer('pertanyaan_id')->nullable();

            $table->string('nama_kec', 255)->nullable();
            $table->string('nama_kel', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kisak_pokja1');
    }
};
