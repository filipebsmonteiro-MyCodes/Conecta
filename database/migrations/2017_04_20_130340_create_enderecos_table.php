<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CEP', 12)		->nullable();
            $table->string('Logradouro', 60)->nullable();
            $table->string('Bairro', 40)	->nullable();
            $table->string('Cidade', 40)	->nullable();
            $table->integer('UFs_idUFs')	->nullable()->unsigned();
            $table->foreign('UFs_idUFs')	->references('id')->on('ufs');
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
        Schema::dropIfExists('enderecos');
    }
}
