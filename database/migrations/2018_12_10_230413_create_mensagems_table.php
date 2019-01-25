<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mensagens', function (Blueprint $table) {
            $table->increments('cd_mensagem');
            $table->unsignedInteger('fk_mensagem_atendimento');
            $table->string('ds_mensagem');
            $table->integer('cd_msgporconsultor');
            $table->foreign('fk_mensagem_atendimento')
                    ->references('cd_atendimento')
                    ->on('tb_atendimentos')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists('tb_mensagens');
    }
}
