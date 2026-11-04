<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('d_penduduk_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->integer('id_kel');
            $table->smallInteger('periode')->default(2026);

            $table->string('no_kk', 20);
            $table->string('nik', 20);
            $table->string('nama', 255);
            $table->string('jenis_kelamin', 1);          // L / P
            $table->boolean('kepala_keluarga')->default(false);

            $table->string('rw', 10)->nullable();
            $table->string('rt', 10)->nullable();
            $table->text('alamat')->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->index(['id_kec', 'id_kel', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('d_penduduk_2026');
    }
};