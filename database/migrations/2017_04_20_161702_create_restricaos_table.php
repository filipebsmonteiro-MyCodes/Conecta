<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestricaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restricaos', function (Blueprint $table) {
        	$table->increments('id');
        	$table->integer('idade_Minima')		->nullable();
        	$table->integer('idade_Maxima')		->nullable();
        	$table->string('genero', 1)			->nullable();
        	$table->integer('EstadoCivils_idEstadoCivils')->nullable()->unsigned();
        	$table->foreign('EstadoCivils_idEstadoCivils')->references('id')->on('estado_civils');
        	$table->integer('Eventos_idEventos')->unsigned();
        	$table->foreign('Eventos_idEventos')->references('id')->on('eventos');
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
        Schema::dropIfExists('restricaos');
    }
}
