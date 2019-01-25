<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_consultores', function (Blueprint $table) {
            $table->increments('cd_consultor');
            $table->string('nm_consultor', 100);
            $table->string('cd_cpf', 11);
            $table->date('dt_nascimento')->nullable();
            $table->char('ic_sexo', 1)->nullable();
            $table->string('cd_celular', 11)->nullable();
            $table->string('sg_estado', 2)->nullable();
            $table->string('nm_cidade', 100)->nullable();
            $table->string('ds_observacao', 300)->nullable();
            $table->string('ds_consultor', 1500)->nullable();
            $table->timestamp('dt_login')->nullable();
            $table->string('img_consultor', 255);
            $table->double('qt_creditos');
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
        Schema::dropIfExists('consultors');
    }
}
