<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transferencias', function (Blueprint $table) {
            $table->increments('cd_transferencia');
            $table->date('dt_pagamento');
            $table->string('dt_periodo_pago', 25);
            $table->double('vl_total', 8, 2);
            $table->double('vl_comissao', 7, 2);
            $table->integer('qnt_atendimento');
            $table->unsignedInteger('fk_transferencia_consultor');
            $table->foreign('fk_transferencia_consultor')
                  ->references('cd_consultor')
                  ->on('tb_consultores')
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
        Schema::dropIfExists('transferencias');
    }
}
