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
        Schema::table('data_umum_2026', function (Blueprint $table) {
            $table->dropUnique(['id_kec', 'periode']);
            $table->integer('id_kel')->nullable()->after('id_kec');
            $table->index(['id_kec', 'id_kel', 'periode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_umum_2026', function (Blueprint $table) {
            $table->dropIndex(['id_kec', 'id_kel', 'periode']);
            $table->dropColumn('id_kel');
            $table->unique(['id_kec', 'periode']);
        });
    }
};
