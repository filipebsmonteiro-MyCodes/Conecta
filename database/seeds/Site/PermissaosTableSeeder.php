<?php

use Illuminate\Database\Seeder;
use App\Models\Site\Perfil_has_permissao;
use App\Models\Site\User_has_perfil;

class PermissaosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Perfils -> Permissaos
         */
    	//Recepçao -> Convidado
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 1, 'Permissaos_idPermissaos'	=> 1]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 1, 'Permissaos_idPermissaos'	=> 2]);//Update
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 1, 'Permissaos_idPermissaos'	=> 3]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 1, 'Permissaos_idPermissaos'	=> 5]);//Presenca
    		
    		
    	//Evento_gestor -> Evento
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 2, 'Permissaos_idPermissaos'	=> 6]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 2, 'Permissaos_idPermissaos'	=> 7]);//Update
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 2, 'Permissaos_idPermissaos'	=> 8]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 2, 'Permissaos_idPermissaos'	=> 9]);//Delete
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 2, 'Permissaos_idPermissaos'	=> 10]);//Presenca
    		
    		//Evento_gestor -> Membro
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 2, 'Permissaos_idPermissaos'	=> 13]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 2, 'Permissaos_idPermissaos'	=> 15]);//Show
    		
    		
    	//Celula_Super -> Rede
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 16]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 17]);//Update
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 18]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 19]);//Show
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 20]);//Delete
    		
    		//Celula_Super -> Celula
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 21]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 22]);//Update
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 23]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 24]);//Show
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 3, 'Permissaos_idPermissaos'	=> 25]);//Delete
    		
    		
    	//Celula_Lider -> Celula
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 21]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 22]);//Update
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 23]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 24]);//Show
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 25]);//Delete
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 26]);//Gerenciar
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 27]);//Lideranca
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 28]);//Reciclar
    		
    		//Celula_Lider -> Convidado
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 1]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 2]);//Update
    		
    		//Perfil_has_permissao::create(['Perfils_idPerfils'		=> 4, 'Permissaos_idPermissaos'	=> 3]);//List
    	
    	//Secretariado -> Regiao
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 29]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 30]);//Update
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 31]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 32]);//Delete
    		
    		//Secretariado -> Membro
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 11]);//Create
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 12]);//Update
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 13]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 14]);//Delete
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 5, 'Permissaos_idPermissaos'	=> 15]);//Show
    		
    	//Pastorado -> Convidado
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 3]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 4]);//Show
    		
    		//Pastorado -> Celula
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 23]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 24]);//Show
    		
    		//Pastorado -> Rede
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 18]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 19]);//Show
    		
    		//Pastorado -> Membro
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 13]);//List
    		
    		Perfil_has_permissao::create(['Perfils_idPerfils'		=> 6, 'Permissaos_idPermissaos'	=> 15]);//Show
    		
    	/**
    	 * User -> Perfil
    	 */
    	User_has_perfil::create(['Users_idUsers'				=> 1, 'Perfils_idPerfils'	=> 1]);
    	
    	User_has_perfil::create(['Users_idUsers'				=> 2, 'Perfils_idPerfils'	=> 2]);
    	
    	User_has_perfil::create(['Users_idUsers'				=> 3, 'Perfils_idPerfils'	=> 3]);
    	
    	User_has_perfil::create(['Users_idUsers'				=> 4, 'Perfils_idPerfils'	=> 4]);
    	
    	User_has_perfil::create(['Users_idUsers'				=> 5, 'Perfils_idPerfils'	=> 5]);
    	
    	User_has_perfil::create(['Users_idUsers'				=> 6, 'Perfils_idPerfils'	=> 6]);
    	
    	User_has_perfil::create(['Users_idUsers'				=> 7, 'Perfils_idPerfils'	=> 7]);
    		
    }
}
