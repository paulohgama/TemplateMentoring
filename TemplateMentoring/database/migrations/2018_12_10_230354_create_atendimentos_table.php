<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_atendimentos', function (Blueprint $table) {
            $table->increments('cd_atendimento');
            $table->unsignedInteger('fk_atendimento_consultor');
            $table->unsignedInteger('fk_atendimento_visitante');
            $table->date('dt_atendimento');
            $table->time('hr_inicio')->nullable();
            $table->time('hr_cobranca')->nullable();
            $table->time('hr_termino')->nullable();
            $table->boolean('status_transacao')->default(0);
            $table->double('vl_total', 7, 2)->nullable();
            $table->unsignedInteger('status_atendimento');
            $table->foreign('fk_atendimento_consultor')
                  ->references('cd_consultor')
                  ->on('tb_consultores')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('fk_atendimento_visitante')
                  ->references('cd_visitante')
                  ->on('tb_visitantes')
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
        Schema::dropIfExists('atendimentos');
    }
}
