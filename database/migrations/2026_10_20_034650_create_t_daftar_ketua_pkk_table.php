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
        Schema::create('t_daftar_ketua_pkk', function (Blueprint $table) {
            $table->id();
            $table->string('file_pdf');                  
            $table->string('original_name');             
            $table->string('created_by')->nullable();    
            $table->string('updated_by')->nullable();    
            $table->string('deleted_by')->nullable();                      
            $table->softDeletes();                      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_daftar_ketua_pkk');
    }
};