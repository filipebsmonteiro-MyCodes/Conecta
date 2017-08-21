<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvidadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convidados', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('nome', 30);
        	$table->string('email', 70)			->nullable();
        	$table->date('data_nascimento')		->nullable();
        	$table->string('genero', 1)			->nullable();
        	$table->string('celular', 16)		->nullable();
        	$table->string('discipulador', 30)	->nullable();
        	$table->integer('Regiaos_idRegiaos')		->nullable()->unsigned();
        	$table->foreign('Regiaos_idRegiaos')		->references('id')->on('regiaos');
        	$table->integer('Igrejas_idIgrejas')		->unsigned();
        	$table->foreign('Igrejas_idIgrejas')		->references('id')->on('Igrejas');
            
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
        Schema::dropIfExists('convidados');
    }
}
