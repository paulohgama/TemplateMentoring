<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_vendas', function (Blueprint $table) {
            $table->increments('cd_venda');
            $table->date('dt_venda');
            $table->unsignedInteger('fk_vendas_visitante');
            $table->double('cd_compra', 7, 2);
            $table->string('st_status', 100);
            $table->foreign('fk_vendas_visitante')
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
        Schema::dropIfExists('tb_vendas');
    }
}
