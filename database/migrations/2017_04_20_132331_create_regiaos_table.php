<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegiaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regiaos', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('nome', 45);
        	$table->integer('Igrejas_idIgrejas')->unsigned();
        	$table->foreign('Igrejas_idIgrejas')->references('id')->on('Igrejas');
        	
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
        Schema::dropIfExists('regiaos');
    }
}
