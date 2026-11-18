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
        Schema::create('m_lotus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pertanyaan_id');
            $table->string('name', 255);
            $table->string('nama_kec', 255)->nullable();
            $table->string('nama_kel', 255)->nullable();
            $table->string('tahap', 255)->nullable();
            $table->bigInteger('id_kec')->nullable();
            $table->bigInteger('id_kel')->nullable();
            $table->bigInteger('rw')->nullable();
            $table->bigInteger('rt')->nullable();
            $table->softDeletes(); // deleted_at (timestamp nullable)
            $table->timestamps();  // created_at & updated_at
            $table->text('alamat')->nullable();
            $table->string('flag_kolom', 255)->nullable();
            $table->string('tahun', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_lotus');
    }
};
