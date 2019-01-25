<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialidadeConsultorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_especialidades_consultores', function (Blueprint $table) {
            $table->unsignedInteger('fk_consultor_especialidade');
            $table->unsignedInteger('fk_especialidade_consultor');
            $table->foreign('fk_especialidade_consultor')
                  ->references('cd_consultor')
                  ->on('tb_consultores')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('fk_consultor_especialidade')
                  ->references('cd_especialidade')
                  ->on('tb_especialidades')
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
        Schema::dropIfExists('especialidade_consultors');
    }
}
