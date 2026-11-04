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
        Schema::create('d_kader_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->integer('id_kel');
            $table->smallInteger('periode')->default(2026);

            // anggota_tp_pkk / umum / khusus
            $table->string('jenis_kader', 30);

            $table->string('nik', 20);
            $table->string('nama', 255);
            $table->string('jenis_kelamin', 1);   // L / P
            $table->string('no_kk', 20)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('rt', 10)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('nama_role', 100)->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->index(['id_kec', 'id_kel', 'periode', 'jenis_kader']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_kader_2026');
    }
};
