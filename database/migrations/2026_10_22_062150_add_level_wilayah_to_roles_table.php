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
        Schema::table('roles', function (Blueprint $table) {
            $table->string('level_wilayah', 20)->nullable()->after('guard_name');
        });

        DB::table('roles')->where('name', 'pkk_kelurahan')->update(['level_wilayah' => 'kelurahan']);
        DB::table('roles')->where('name', 'pkk_kecamatan')->update(['level_wilayah' => 'kecamatan']);
        DB::table('roles')->whereIn('name', ['superadmin', 'admin', 'admin_pkk'])->update(['level_wilayah' => 'kota']);
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('level_wilayah');
        });
    }
};
