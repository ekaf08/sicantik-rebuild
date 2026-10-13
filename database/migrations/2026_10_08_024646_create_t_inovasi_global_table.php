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
        Schema::create('t_inovasi_global', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_entry');
            $table->string('nama_inovasi');
            $table->text('deskripsi_inovasi');
            $table->enum('pokja', [
                'Sekretaris',
                'POKJA 1',
                'POKJA 2',
                'POKJA 3',
                'POKJA 4',
            ]);
            
            $table->string('periode', 4)->default('2026');
            $table->string('file_dokumen')->nullable(); 
            $table->string('foto_1')->nullable();       
            $table->string('foto_2')->nullable();      
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('id_kec');
            $table->unsignedBigInteger('id_kel')->nullable();
            $table->foreignId('created_by') ->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_inovasi_global');
    }
};