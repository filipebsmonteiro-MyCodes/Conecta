<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('perfils', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('name', 45);
    		$table->string('description', 200);
    		$table->timestamps();
    	});
    	
    	Schema::create('user_has_perfils', function (Blueprint $table) {
    		$table->increments('id');
    		$table->integer('Users_idUsers')	->unsigned();
    		$table->foreign('Users_idUsers')	->references('id')->on('Users');
    		$table->integer('Perfils_idPerfils')->unsigned();
    		$table->foreign('Perfils_idPerfils')->references('id')->on('Perfils');
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
    	Schema::dropIfExists('user_has_perfils');
    	Schema::dropIfExists('perfils');
    }
}
