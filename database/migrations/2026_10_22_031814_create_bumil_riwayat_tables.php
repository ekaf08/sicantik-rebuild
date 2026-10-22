<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bumil_kehamilan')) {
            Schema::create('bumil_kehamilan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('bumil_id');
                $table->date('tanggal')->nullable();
                $table->unsignedSmallInteger('usia_kehamilan')->nullable();   // dalam minggu
                $table->decimal('hb', 4, 1)->nullable();                      // g/dL
                $table->decimal('bb', 5, 1)->nullable();                      // kg
                $table->decimal('tb', 5, 1)->nullable();                      // cm
                $table->decimal('imt', 5, 2)->nullable();
                $table->decimal('lila', 4, 1)->nullable();                    // cm
                $table->string('tensi', 12)->nullable();                      // contoh: 100/70
                $table->decimal('tfu', 4, 1)->nullable();                     // cm
                $table->unsignedSmallInteger('djj')->nullable();              // x per menit
                $table->timestamps();
                $table->softDeletes();

                $table->index('bumil_id');
            });
        }

        if (!Schema::hasTable('bumil_calon_pengantin')) {
            Schema::create('bumil_calon_pengantin', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('bumil_id');
                $table->string('nik', 20)->nullable();
                $table->date('tanggal')->nullable();
                $table->string('hasil_pemeriksaan')->nullable();
                $table->decimal('bb', 5, 1)->nullable();
                $table->decimal('tb', 5, 1)->nullable();
                $table->decimal('lila', 4, 1)->nullable();
                $table->decimal('imt', 5, 2)->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('bumil_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bumil_calon_pengantin');
        Schema::dropIfExists('bumil_kehamilan');
    }
};
