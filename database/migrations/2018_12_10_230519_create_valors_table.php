<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_valores', function (Blueprint $table) {
            $table->increments('cd_valor');
            $table->double('valor', 5, 2);
            $table->date('dt_mudanca');//data da mudança de valor
            $table->time('hr_mudanca');//hora da mudança de valor
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
        Schema::dropIfExists('tb_valores');
    }
}
