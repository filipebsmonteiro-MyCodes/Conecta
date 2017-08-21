<?php

use Illuminate\Database\Seeder;
use App\Models\Site\Rede;
use App\Models\Site\Celula;
use App\Models\Site\Igreja;

class CelulaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Igreja $igreja)
    {
        $igrejas	= $igreja->all();
        
        foreach ($igrejas as $ig){
        	
        	Rede::create([
        			'Nome'						=> 'Rede Nenhuma',
        			'Users_idSupervisor'		=> 1,
        			'Igrejas_idIgrejas'			=> $ig->id
        	]);
        	
        	Celula::create([
        			'Nome'						=> 'Nenhuma',
        			'Redes_idRedes'				=> 1,
        			'Igrejas_idIgrejas'			=> $ig->id
        			
        	]);
        }
    }
}
