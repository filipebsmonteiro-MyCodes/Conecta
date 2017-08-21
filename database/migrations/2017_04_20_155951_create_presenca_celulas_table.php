<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresencaCelulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presenca_celulas', function (Blueprint $table) {
        	$table->increments('id');
        	$table->integer('Celulas_idCelulas')					->unsigned();
        	$table->foreign('Celulas_idCelulas')					->references('id')->on('celulas');
        	$table->integer('User_has_Celulas_idUser_has_Celulas')	->unsigned();
            $table->foreign('User_has_Celulas_idUser_has_Celulas')	->references('id')->on('user_has_Celulas');
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
        Schema::dropIfExists('presenca_celulas');
    }
}
