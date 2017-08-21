<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissaos', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('name', 45);
        	$table->string('description', 200);
            $table->timestamps();
        });
        	
        Schema::create('perfil_has_permissaos', function (Blueprint $table) {
        	$table->increments('id');
        	$table->integer('Perfils_idPerfils')		->unsigned();
        	$table->foreign('Perfils_idPerfils')		->references('id')->on('perfils');
        	$table->integer('Permissaos_idPermissaos')	->unsigned();
        	$table->foreign('Permissaos_idPermissaos')	->references('id')->on('permissaos');
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
    	Schema::dropIfExists('perfil_has_permissaos');
    	Schema::dropIfExists('permissaos');
    }
}
