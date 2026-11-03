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
        Schema::create('d_dasa_wisma_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->integer('id_kel');
            $table->smallInteger('periode')->default(2026);

            $table->string('nama_dasawisma', 255);
            $table->string('rw', 10)->nullable();
            $table->string('rt', 10)->nullable();

            $table->string('nik_koordinator', 20)->nullable();
            $table->string('nama_koordinator', 255)->nullable();

            $table->text('catatan')->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->index(['id_kec', 'id_kel', 'periode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_dasa_wisma_2026');
    }
};
