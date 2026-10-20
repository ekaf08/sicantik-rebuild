<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tabel = (new \App\Models\Penghargaan())->getTable();

        Schema::table($tabel, function (Blueprint $table) use ($tabel) {
            if (!Schema::hasColumn($tabel, 'kecamatan_id')) {
                $table->string('kecamatan_id')->nullable();
            }
            if (!Schema::hasColumn($tabel, 'kelurahan_id')) {
                $table->string('kelurahan_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        $tabel = (new \App\Models\Penghargaan())->getTable();

        Schema::table($tabel, function (Blueprint $table) use ($tabel) {
            foreach (['kecamatan_id', 'kelurahan_id'] as $kolom) {
                if (Schema::hasColumn($tabel, $kolom)) {
                    $table->dropColumn($kolom);
                }
            }
        });
    }
};
