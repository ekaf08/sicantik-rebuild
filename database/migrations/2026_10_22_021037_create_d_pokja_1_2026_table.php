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
        Schema::create('d_pokja_1_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->integer('id_kel')->nullable();
            $table->smallInteger('periode')->default(2026);

            $table->unsignedInteger('jumlah_kader')->default(0);

            foreach (['kisah', 'krisan', 'kilas', 'kiat', 'kisak', 'pkbn'] as $g) {
                $table->string($g . '_kegiatan', 255)->nullable();
                $table->unsignedInteger($g . '_volume')->default(0);
                $table->string($g . '_metode', 255)->nullable();
                $table->unsignedInteger($g . '_peserta')->default(0);
            }

            $table->timestamps();

            $table->index(['id_kec', 'id_kel', 'periode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_pokja_1_2026');
    }
};
