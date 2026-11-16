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
        //Penyesuaian Pokja 3
        DB::statement('
            ALTER TABLE "public"."d_kader_2026"
            ALTER COLUMN "jenis_kader" TYPE varchar(100)
        ');

        //Create Toga
        DB::statement('
            CREATE TABLE IF NOT EXISTS "public"."d_toga_2026" (
              "id" bigserial PRIMARY KEY,
              "id_kec" int8 NOT NULL,
              "id_kel" int8 NOT NULL DEFAULT 0,
              "periode" int2 NOT NULL DEFAULT 2026,
              "no_kk" varchar(16) NOT NULL,
              "nik_kepala_keluarga" varchar(16),
              "nama_kepala_keluarga" varchar(255) NOT NULL,
              "alamat" text,
              "rt" varchar(10),
              "rw" varchar(10),
              "nama_jawaban" varchar(20) NOT NULL DEFAULT \'Ya\',
              "created_by" int8,
              "updated_by" int8,
              "deleted_by" int8,
              "created_at" timestamp(0),
              "updated_at" timestamp(0),
              "deleted_at" timestamp(0)
            )
        ');

        DB::statement('
            CREATE INDEX IF NOT EXISTS "idx_d_toga_2026_wilayah_periode"
            ON "public"."d_toga_2026" ("id_kec", "id_kel", "periode")
            WHERE "deleted_at" IS NULL
        ');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS "public"."d_toga_2026"');
        DB::statement('DROP TABLE IF EXISTS "public"."d_pokja_3_2026"');
    }
};
