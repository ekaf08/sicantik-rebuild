<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jenis risiko kehamilan (satu ibu bisa punya lebih dari satu)
        if (!Schema::hasTable('bumil_risiko')) {
            Schema::create('bumil_risiko', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('bumil_id');
                $table->string('jenis_risiko', 100);                 // contoh: Anemia, Hipertensi, KEK, Terlalu muda/tua
                $table->text('keterangan')->nullable();
                $table->date('tanggal')->nullable();                 // tanggal risiko dicatat
                $table->timestamps();
                $table->softDeletes();

                $table->index('bumil_id');
            });
        }

        // Kejadian persalinan / hasil kehamilan (satu baris per kehamilan yang berakhir)
        if (!Schema::hasTable('bumil_persalinan')) {
            Schema::create('bumil_persalinan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('bumil_id');
                $table->unsignedTinyInteger('hamil_ke')->nullable();          // kehamilan yang ke berapa
                $table->date('tanggal')->nullable();                          // tanggal persalinan / kejadian
                $table->string('cara_persalinan', 30)->nullable();            // normal / sc / vakum / lainnya
                $table->string('tempat_persalinan')->nullable();
                $table->string('status_kelahiran', 20)->nullable();           // lahir_hidup / lahir_mati / keguguran
                $table->timestamps();
                $table->softDeletes();

                $table->index('bumil_id');
            });
        }

        // Kunjungan nifas
        if (!Schema::hasTable('bumil_nifas')) {
            Schema::create('bumil_nifas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('bumil_id');
                $table->unsignedBigInteger('persalinan_id')->nullable();
                $table->date('tanggal')->nullable();                          // tanggal kunjungan nifas
                $table->unsignedSmallInteger('hari_nifas')->nullable();       // hari ke-berapa setelah melahirkan
                $table->string('tensi', 12)->nullable();
                $table->decimal('suhu', 3, 1)->nullable();                    // derajat celsius
                $table->string('kondisi_ibu')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('bumil_id');
                $table->index('persalinan_id');
            });
        }

        // Data anak yang lahir (menempel ke persalinan, lalu ke ibu)
        if (!Schema::hasTable('bumil_anak')) {
            Schema::create('bumil_anak', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('persalinan_id');
                $table->string('nama')->nullable();
                $table->string('jenis_kelamin', 10)->nullable();              // Laki-laki / Perempuan
                $table->date('tanggal_lahir')->nullable();
                $table->unsignedSmallInteger('berat_lahir')->nullable();      // gram
                $table->decimal('panjang_lahir', 4, 1)->nullable();           // cm
                $table->timestamps();
                $table->softDeletes();

                $table->index('persalinan_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bumil_anak');
        Schema::dropIfExists('bumil_nifas');
        Schema::dropIfExists('bumil_persalinan');
        Schema::dropIfExists('bumil_risiko');
    }
};
