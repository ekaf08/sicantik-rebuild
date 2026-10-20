<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pisang_organik', function (Blueprint $table) {
            if (!Schema::hasColumn('pisang_organik', 'upload_file_1')) {
                $table->string('upload_file_1')->nullable();
            }
            if (!Schema::hasColumn('pisang_organik', 'upload_file_2')) {
                $table->string('upload_file_2')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pisang_organik', function (Blueprint $table) {
            $table->dropColumn(['upload_file_1', 'upload_file_2']);
        });
    }
};
