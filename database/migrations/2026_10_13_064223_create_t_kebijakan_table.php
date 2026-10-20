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
        Schema::create('t_kebijakan', function (Blueprint $table) {
            $table->id();
            $table->string('no_sk')->index();
            $table->string('perihal');
            $table->string('id_kec')->nullable();
            $table->string('id_kel')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->string('file_sk')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('kota')->default('KOTA SURABAYA');
            $table->integer('tahun')->nullable();
            $table->string('pokja')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_kebijakan');
    }
};