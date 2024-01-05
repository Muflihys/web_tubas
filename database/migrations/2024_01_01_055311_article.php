<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_artikels', function (Blueprint $table) {
            $table->id();
            $table->string('Judul Artikel');
            $table->string('Penulis');
            $table->string('Nama Jurnal');
            $table->string('Volume Jurnal');
            $table->string('Halaman');
            $table->string('ISSN');
            $table->string('Penerbit');
            $table->string('FileUpload');
            $table->timestamps();

            
        });
        DB::statement("ALTER TABLE tb_artikels MODIFY FileUpload VARCHAR(255) DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_artikels');
    }
};
