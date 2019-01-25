<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_usuarios', function (Blueprint $table) {
            $table->increments('cd_usuario');
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->unsignedInteger('cd_usuario_fk');
            $table->boolean('status')->default(1); // 1- ativo, 0 - Bloqueado
            $table->tinyInteger('cd_role'); //1 - Admin, 2 - Consultor, 3 - Visitante
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_usuario');
    }
}
