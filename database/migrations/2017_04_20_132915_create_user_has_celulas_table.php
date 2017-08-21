<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHasCelulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_celulas', function (Blueprint $table) {
        	$table->increments('id');
        	$table->integer('Celulas_idCelulas')		->unsigned()->default('0');
        	$table->foreign('Celulas_idCelulas')		->references('id')->on('celulas');
        	$table->integer('Users_idUsers')			->nullable()->unsigned();
        	$table->foreign('Users_idUsers')			->references('id')->on('users')		->nullable()->default(null);
        	$table->integer('Convidados_idConvidados')	->nullable()->unsigned();
            $table->foreign('Convidados_idConvidados')	->references('id')->on('convidados')->nullable()->default(null);
            $table->enum('cargo', ['Membro', 'Visitante', 'Lider', 'Lider em Treinamento'])->default('Membro');
            //$table->integer('Ativo')->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_celulas');
    }
}
