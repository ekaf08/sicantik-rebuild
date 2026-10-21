<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tabel = ['penghargaans', 'pisang_bsi', 'pisang_organik', 'pmt', 'makan_ketan'];

    public function up(): void
    {
        foreach ($this->tabel as $nama) {
            if (Schema::hasTable($nama) && !Schema::hasColumn($nama, 'deleted_at')) {
                Schema::table($nama, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tabel as $nama) {
            if (Schema::hasTable($nama) && Schema::hasColumn($nama, 'deleted_at')) {
                Schema::table($nama, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
