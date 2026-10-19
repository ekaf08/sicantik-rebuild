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
        Schema::create('m_pertanyaan_dashboard_2026', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->string('nama_pertanyaan', 255);
            $table->string('tb_dashboard', 255);

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->boolean('is_kader')->nullable()->comment('flag jenis onclick pada kode dan flag untuk modal');
            $table->string('flag_kader', 255)->nullable()->comment('nama flag kader pada onclick');
            $table->boolean('is_disable')->nullable()->comment('flag untuk disable data pada dashboard PKK (tidak bisa diklik)');
            $table->string('alias', 255)->nullable()->comment('bridging nama kolom pada masing-masing tabel agg');
            $table->smallInteger('urutan')->nullable()->comment('urutan pertanyaan');
            $table->boolean('is_tarik')->nullable()->comment('pengecekan button tambah kader pada modal');
            $table->string('value_param', 255)->nullable()->comment('value param untuk kolom pada masing-masing tabel detail');
            $table->bigInteger('jenis_form')->nullable()->comment('0 = modal standar / m_kader, 1 = modal detail, 2 = form');
            $table->boolean('is_row')->nullable()->comment('f = ikut loopingan kelurahan/kecamatan, t = baris baru');
            $table->bigInteger('merge_id')->nullable()->comment('kolom berisi id pertanyaan yang nilai jawabannya akan digabung');
            $table->bigInteger('parent_id')->nullable()->comment('NULL = parent, NOT NULL = children');
            $table->boolean('is_keterangan')->nullable()->comment('flag keterangan untuk membedakan apakah tabel perlu keterangan');
            $table->smallInteger('periode')->nullable();
            $table->string('where_param', 255)->nullable();
            $table->text('query_detail')->nullable()->comment('query untuk detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pertanyaan_dashboard_2026');
    }
};
