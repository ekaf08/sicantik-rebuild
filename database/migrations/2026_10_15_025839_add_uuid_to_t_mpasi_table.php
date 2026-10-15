<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('t_mpasi', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id_mpasi');
        });

        DB::table('t_mpasi')->whereNull('uuid')->orderBy('id_mpasi')->each(function ($row) {
            DB::table('t_mpasi')
                ->where('id_mpasi', $row->id_mpasi)
                ->update(['uuid' => (string) Str::uuid()]);
        });

        Schema::table('t_mpasi', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    public function down(): void
    {
        Schema::table('t_mpasi', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};