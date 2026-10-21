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
        Schema::create('d_pokja_2_2026', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kec');
            $table->smallInteger('periode')->default(2026);

            $kolom = [
                'warga_3_buta',
                'paket_a_klp', 'paket_a_warga', 'paket_b_klp', 'paket_b_warga',
                'paket_c_klp', 'paket_c_warga', 'kf_klp', 'kf_warga',
                'paud_sejenis', 'taman_bacaan',
                'bkb_kelp', 'bkb_ibu_peserta', 'bkb_ape', 'bkb_kelp_simulasi',
                'tutor_kf', 'tutor_paud_sejenis',
                'kader_bkb', 'kader_koperasi', 'kader_keterampilan',
                'lp3_pkk', 'tpk3_pkk', 'damas_pkk',
                'pemula_kelp', 'pemula_psrt', 'madya_kelp', 'madya_psrt',
                'utama_kelp', 'utama_psrt', 'mandiri_kelp', 'mandiri_psrt',
                'koperasi', 'anggota',
            ];

            foreach ($kolom as $k) {
                $table->unsignedInteger($k)->default(0);
            }

            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['id_kec', 'periode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_pokja_2_2026');
    }
};
