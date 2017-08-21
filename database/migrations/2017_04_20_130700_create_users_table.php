<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	//2014_10_12_000000_create_users_table
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('email', 70)->unique()->nullable();
        	$table->string('password', 150)->nullable();
        	$table->string('first_name', 30);
        	$table->string('last_name', 30)->nullable();
        	$table->string('nickname', 30)->nullable();
        	
        	$table->integer('EstadoCivils_idEstadoCivils')	->unsigned()->nullable();
            $table->foreign('EstadoCivils_idEstadoCivils')	->references('id')->on('estado_civils');
            $table->date('birthday')			->nullable();
            $table->string('gender', 1)			->nullable();
            $table->string('phone', 16)			->nullable();
            $table->string('mobile', 16)		->nullable();
            $table->string('CPF', 14)			->nullable();
            $table->string('RG', 20)			->nullable();
            $table->string('Emissor', 10)		->nullable();
            $table->integer('Enderecos_idEnderecos')		->unsigned()->nullable();
            $table->foreign('Enderecos_idEnderecos')		->references('id')->on('enderecos');
            $table->integer('TipoMembros_idTipoMembros')	->unsigned()->nullable();
            $table->foreign('TipoMembros_idTipoMembros')	->references('id')->on('tipo_membros');
            $table->integer('TipoEntradas_idTipoEntradas')	->unsigned()->nullable();
            $table->foreign('TipoEntradas_idTipoEntradas')	->references('id')->on('tipo_entradas');
            $table->date('DataEntrada')			->nullable();
            $table->string('IgrejaDeOrigem', 30)->nullable();
            $table->string('idFoto', 20)		->nullable();
            $table->integer('Users_idDiscipulador')->nullable();
            $table->integer('Igrejas_idIgrejas')			->unsigned();
            $table->foreign('Igrejas_idIgrejas')			->references('id')->on('Igrejas');
            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
