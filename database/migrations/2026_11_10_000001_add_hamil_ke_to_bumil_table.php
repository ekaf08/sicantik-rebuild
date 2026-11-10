<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bumil', function (Blueprint $table) {
            if (!Schema::hasColumn('bumil', 'hamil_ke')) {
                $table->unsignedTinyInteger('hamil_ke')->nullable()->after('usia');          // kehamilan yang ke berapa
            }
            if (!Schema::hasColumn('bumil', 'tanggal_melahirkan')) {
                $table->date('tanggal_melahirkan')->nullable()->after('tanggal');             // terisi = sudah melahirkan (pindah ke nifas)
            }
        });
    }

    public function down(): void
    {
        Schema::table('bumil', function (Blueprint $table) {
            if (Schema::hasColumn('bumil', 'hamil_ke')) {
                $table->dropColumn('hamil_ke');
            }
            if (Schema::hasColumn('bumil', 'tanggal_melahirkan')) {
                $table->dropColumn('tanggal_melahirkan');
            }
        });
    }
};
