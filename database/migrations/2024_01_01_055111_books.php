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
        Schema::create('tb_books', function (Blueprint $table) {
                $table->id();
                $table->string('Judul');
                $table->string('Penulis');
                $table->string('ISBN'); 
                $table->string('Penerbit');
                $table->integer('Jumlah_Halaman');
                $table->string('FileUpload');
                $table->timestamps();
        });
        DB::statement("ALTER TABLE tb_books MODIFY FileUpload VARCHAR(255) DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_books');
    }
};
