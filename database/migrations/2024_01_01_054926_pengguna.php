<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class CreateTbpenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pengguna', function (Blueprint $table) {
            $table->increments('id_pengguna');
            $table->string('nama_pengguna');
            $table->string('email_pengguna');
            $table->string('username_pengguna');
            $table->string('password_pengguna');
            $table->string('foto_pengguna');
            $table->string('remember_token');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE tb_pengguna MODIFY remember_token VARCHAR(255) DEFAULT NULL;");
        DB::statement("ALTER TABLE tb_pengguna MODIFY foto_pengguna VARCHAR(255) DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pengguna');
    }
}
