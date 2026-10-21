<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('kemangi')) {
            return;
        }

        Schema::create('kemangi', function (Blueprint $table) {
            $table->id();
            $table->string('kelompok', 20);          // Remaja / Orang Tua
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('tahun', 4);
            $table->decimal('nilai_pre', 6, 2)->default(0);
            $table->decimal('nilai_post', 6, 2)->default(0);
            $table->unsignedInteger('jumlah_peserta')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kemangi');
    }
};
