<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prazos', function (Blueprint $table) {
        	$table->increments('id');
        	$table->integer('Eventos_idEventos')->unsigned();
            $table->foreign('Eventos_idEventos')->references('id')->on('eventos');
            $table->date('Prazo_Data');
            $table->double('Prazo_Valor')		->nullable()->default(0.0);
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
        Schema::dropIfExists('prazos');
    }
}
