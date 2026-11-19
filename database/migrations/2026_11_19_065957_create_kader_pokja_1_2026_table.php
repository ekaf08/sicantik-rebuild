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
        Schema::create('kader_pokja_1_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec')->nullable()->index();
            $table->integer('id_kel')->nullable()->index();
            $table->integer('periode')->default(2026)->index();
            $table->string('nik', 20)->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('jenis_kelamin', 5)->nullable();
            $table->string('no_kk', 20)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('rt', 10)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('nama_role', 100)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kader_pokja_1_2026');
    }
};
