<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nome', 45);
            $table->date('Inicio');
            $table->date('Final');
            $table->string('Local', 45);
            $table->integer('Quantidade_Vagas');
            $table->longText('description')			->nullable();
            $table->integer('Ativo')				->default(0);
			$table->string('Nome_Banco', 30)		->nullable();
			$table->string('Agencia', 20)			->nullable();
			$table->string('Conta', 20)				->nullable();
			$table->string('Tipo_Conta', 20)		->nullable();
			$table->string('Cpf_Cnpj', 20)			->nullable();
			$table->string('Nome_Beneficiario', 30)	->nullable();
			$table->string('Email_PagSeguro', 70)	->nullable();
			$table->string('Token_PagSeguro', 32)	->nullable();
			$table->integer('Igrejas_idIgrejas')	->unsigned();
			$table->foreign('Igrejas_idIgrejas')	->references('id')->on('Igrejas');
			
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
        Schema::dropIfExists('eventos');
    }
}
