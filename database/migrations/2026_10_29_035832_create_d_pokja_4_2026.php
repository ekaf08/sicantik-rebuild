<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('d_pokja_4_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->integer('id_kel')->nullable(); // NULL = baris tingkat kecamatan
            $table->smallInteger('periode')->default(2026);

            // Kesehatan - Jumlah Kader (3-8)
            $table->unsignedInteger('kader_kesehatan')->default(0);
            $table->unsignedInteger('gizi')->default(0);
            $table->unsignedInteger('kesling')->default(0);
            $table->unsignedInteger('phbs')->default(0);
            $table->unsignedInteger('kb')->default(0);
            $table->unsignedInteger('kader_sby_hebat')->default(0);

            // Kesehatan (9-12)
            $table->unsignedInteger('posyandu')->default(0);
            $table->unsignedInteger('imunisasi')->default(0);
            $table->unsignedInteger('pkg')->default(0);
            $table->unsignedInteger('tbc')->default(0);

            // Kelestarian Lingkungan Hidup - Jumlah rumah yang memiliki (13-15)
            $table->unsignedInteger('jamban')->default(0);
            $table->unsignedInteger('spal')->default(0);
            $table->unsignedInteger('tempat_sampah')->default(0);

            // Jumlah MCK (16)
            $table->unsignedInteger('jumlah_mck')->default(0);

            // Jumlah KRT yang menggunakan air (17-19)
            $table->unsignedInteger('pdam')->default(0);
            $table->unsignedInteger('sumur')->default(0);
            $table->unsignedInteger('lain_lain')->default(0);

            // Perencanaan Sehat (20-25)
            $table->unsignedInteger('jumlah_pus')->default(0);
            $table->unsignedInteger('jumlah_wus')->default(0);
            $table->unsignedInteger('akseptor_kb_l')->default(0);
            $table->unsignedInteger('akseptor_kb_p')->default(0);
            $table->unsignedInteger('jml_kk_dg_tabungan')->default(0);
            $table->unsignedInteger('jml_kk_dg_asuransi_kesehatan')->default(0);

            // Program Unggulan GKSTB (26-28)
            $table->unsignedInteger('kesehatan')->default(0);
            $table->unsignedInteger('kelestarian_lh')->default(0);
            $table->unsignedInteger('perencanaan_sehat')->default(0);

            $table->timestamps();
        });

        DB::statement('CREATE UNIQUE INDEX d_pokja_4_2026_kec_uq ON d_pokja_4_2026 (id_kec, periode) WHERE id_kel IS NULL');
        DB::statement('CREATE UNIQUE INDEX d_pokja_4_2026_kel_uq ON d_pokja_4_2026 (id_kec, id_kel, periode) WHERE id_kel IS NOT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('d_pokja_4_2026');
    }
};