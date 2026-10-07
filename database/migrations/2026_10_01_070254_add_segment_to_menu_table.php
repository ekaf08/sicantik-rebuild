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
        Schema::table('m_menu_copy1', function (Blueprint $table) {
            $table->string('segment')->nullable()->after('nama_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_menu_copy1', function (Blueprint $table) {
            $table->dropColumn('segment');
        });
    }
};
