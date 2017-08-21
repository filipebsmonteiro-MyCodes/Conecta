<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Codigo', 45)->nullable();
            $table->double('Valor_Bruto');
            $table->double('Valor_Liquido')->nullable();
            $table->string('Comentario', 60)->nullable();
            $table->integer('Tipos_Pagamentos_idTipos_Pagamentos')	->unsigned();
            $table->foreign('Tipos_Pagamentos_idTipos_Pagamentos')	->references('id')->on('tipos_pagamentos');
            $table->integer('Status_Pagamentos_idStatus_Pagamentos')->unsigned()->default(1);
            $table->foreign('Status_Pagamentos_idStatus_Pagamentos')->references('id')->on('status_pagamentos');
            $table->integer('Users_has_Eventos_idUsers_has_Eventos')->unsigned();
			$table->foreign('Users_has_Eventos_idUsers_has_Eventos')->references('id')->on('user_has_eventos');
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
        Schema::dropIfExists('pagamentos');
    }
}
