<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTbadminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_admin', function (Blueprint $table) {
            $table->increments('id_admin');
            $table->string('nama_admin');
            $table->string('email_admin');
            $table->string('username_admin');
            $table->string('password_admin');
            $table->string('jabatan');
            $table->string('foto_admin');
            $table->string('remember_token');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE tb_admin MODIFY jabatan ENUM('Admin', 'Super Admin') DEFAULT 'Admin';");
        DB::statement("ALTER TABLE tb_admin MODIFY remember_token VARCHAR(255) DEFAULT NULL;");
        DB::statement("ALTER TABLE tb_admin MODIFY foto_admin VARCHAR(255) DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_admin');
    }
}
