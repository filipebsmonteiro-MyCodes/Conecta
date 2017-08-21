<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCelulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('celulas', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('Nome', 30);
        	$table->integer('Enderecos_idEnderecos')->nullable()->unsigned();
        	$table->foreign('Enderecos_idEnderecos')->references('id')->on('enderecos');
        	$table->integer('Redes_idRedes')		->nullable()->unsigned();
        	$table->foreign('Redes_idRedes')		->references('id')->on('redes');
        	$table->integer('Regiaos_idRegiaos')	->nullable()->unsigned();
        	$table->foreign('Regiaos_idRegiaos')	->references('id')->on('regiaos');
        	$table->integer('Igrejas_idIgrejas')			->unsigned();
        	$table->foreign('Igrejas_idIgrejas')			->references('id')->on('Igrejas');
        	
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
        Schema::dropIfExists('celulas');
    }
}
