<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nome');
            $table->integer('Users_idSupervisor')	->unsigned();
            $table->foreign('Users_idSupervisor')	->references('id')->on('users');
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
        Schema::dropIfExists('redes');
    }
}
