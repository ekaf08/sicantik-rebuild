<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('d_lembaga_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->integer('id_kel');
            $table->smallInteger('periode')->default(2026);

            $table->string('jenis', 20)->default('rw');   // rw / pkk_rw / pkk_rt
            $table->string('rw', 10)->nullable();
            $table->string('nama_ketua', 255)->nullable();
            $table->string('jenis_kelamin', 1)->nullable();
            $table->text('alamat')->nullable();
            $table->string('masa_jabatan', 20)->nullable(); // contoh: 2023 - 2027
            $table->string('telepon', 20)->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->index(['id_kec', 'id_kel', 'periode', 'jenis']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('d_lembaga_2026');
    }
};