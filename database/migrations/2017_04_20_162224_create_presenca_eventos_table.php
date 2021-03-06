<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresencaEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presenca_eventos', function (Blueprint $table) {
        	$table->increments('id');
        	$table->integer('Users_idUsers')	->unsigned();
        	$table->foreign('Users_idUsers')	->references('id')->on('users');
        	$table->integer('Eventos_idEventos')->unsigned();
        	$table->foreign('Eventos_idEventos')->references('id')->on('eventos');
        	$table->date('Data_Encontro');
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
        Schema::dropIfExists('presenca_eventos');
    }
}
