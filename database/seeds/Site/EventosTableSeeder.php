<?php

use Illuminate\Database\Seeder;
use App\Models\Site\Evento;
use Carbon\Carbon;
use App\Models\Site\Prazo;

class EventosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/**
    	 * Eventos
    	 */
    	Evento::create([
    			'Nome'				=> 'Evento Passado',
    			'Inicio'			=> Carbon::today()->previous(Carbon::today()->dayOfWeek),
    			'Final'				=> Carbon::today()->previous(Carbon::today()->dayOfWeek)->addDay(),
    			'Local'				=> 'Igreja',
    			'Quantidade_Vagas'	=> '10',
    			'Ativo'				=> '1',
    			'Igrejas_idIgrejas'	=> '1'
    	]);//1
    	
    	Evento::create([
    			'Nome'				=> 'Evento Presente',
    			'Inicio'			=> Carbon::yesterday(),
    			'Final'				=> Carbon::today()->addDay(),
    			'Local'				=> 'Igreja',
    			'Quantidade_Vagas'	=> '10',
    			'Ativo'				=> '1',
    			'Igrejas_idIgrejas'	=> '1'
    	]);//2
    	
    	Evento::create([
    			'Nome'				=> 'Evento Futuro',
    			'Inicio'			=> Carbon::today()->addWeeks(1),
    			'Final'				=> Carbon::today()->addWeeks(2),
    			'Local'				=> 'Igreja',
    			'Quantidade_Vagas'	=> '10',
    			'Ativo'				=> '1',
    			'Igrejas_idIgrejas'	=> '1'
    	]);//3
    	
    	
    	/**
    	 * Prazos de Inscricoes para os Eventos
    	 */
    	//Passado
    	Prazo::create([
    			'Eventos_idEventos'	=> 1,
    			'Prazo_Data'		=> Carbon::today()->previous(Carbon::today()->dayOfWeek),
    			'Prazo_Valor'		=> 30.00
    	]);
    	Prazo::create([
    			'Eventos_idEventos'	=> 1,
    			'Prazo_Data'		=> Carbon::today()->previous(Carbon::today()->dayOfWeek)->addDay(),
    			'Prazo_Valor'		=> 30.00
    	]);
    	
    	//Presente
    	Prazo::create([
    			'Eventos_idEventos'	=> 2,
    			'Prazo_Data'		=> Carbon::today()->previous(Carbon::today()->dayOfWeek)->addDays(3),
    			'Prazo_Valor'		=> 30.00
    	]);
    	Prazo::create([
    			'Eventos_idEventos'	=> 2,
    			'Prazo_Data'		=> Carbon::today()->previous(Carbon::today()->dayOfWeek)->addDay(5),
    			'Prazo_Valor'		=> 50.00
    	]);
    	Prazo::create([
    			'Eventos_idEventos'	=> 2,
    			'Prazo_Data'		=> Carbon::yesterday(),
    			'Prazo_Valor'		=> 0
    	]);
    	
    	//Futuro
    	Prazo::create([
    			'Eventos_idEventos'	=> 3,
    			'Prazo_Data'		=> Carbon::today(),
    			'Prazo_Valor'		=> 10.00
    	]);
    	Prazo::create([
    			'Eventos_idEventos'	=> 3,
    			'Prazo_Data'		=> Carbon::today()->addDays(4),
    			'Prazo_Valor'		=> 25.00
    	]);
    	Prazo::create([
    			'Eventos_idEventos'	=> 3,
    			'Prazo_Data'		=> Carbon::today()->addWeeks(1),
    			'Prazo_Valor'		=> 00
    	]);
    	
    	
    }
}
