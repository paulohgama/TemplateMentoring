<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepoimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_depoimentos', function (Blueprint $table) {
            $table->increments('cd_depoimento');
            $table->unsignedInteger('fk_depoimento_consultor');
            $table->unsignedInteger('fk_depoimento_visitante');
            $table->date('dt_depoimento');
            $table->double('nt_depoimento', 1, 0);
            $table->string('ds_depoimento');
            $table->foreign('fk_depoimento_consultor')
                  ->references('cd_consultor')
                  ->on('tb_consultores')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreign('fk_depoimento_visitante')
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
        Schema::dropIfExists('depoimentos');
    }
}
