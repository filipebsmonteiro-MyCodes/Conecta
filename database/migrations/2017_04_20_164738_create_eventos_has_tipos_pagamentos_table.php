<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosHasTiposPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos_has_tipos_pagamentos', function (Blueprint $table) {
        	//$table->increments('id');
        	$table->integer('Eventos_idEventos')	->unsigned();
        	$table->foreign('Eventos_idEventos')	->references('id')->on('eventos');
        	$table->integer('idTipos_Pagamentos')	->unsigned();
        	$table->foreign('idTipos_Pagamentos')	->references('id')->on('tipos_pagamentos');
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
        Schema::dropIfExists('eventos_has_tipos_pagamentos');
    }
}
