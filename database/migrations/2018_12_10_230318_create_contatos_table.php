<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_contatos', function (Blueprint $table) {
            $table->increments('cd_contato');
            $table->string('nm_contato', 100);
            $table->string('nm_email', 100);
            $table->string('cd_celular', 11);
            $table->string('ds_mensagem', 1500);
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
        Schema::dropIfExists('tb_contatos');
    }
}
