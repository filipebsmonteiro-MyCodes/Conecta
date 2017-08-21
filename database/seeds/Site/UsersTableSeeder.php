<?php

use Illuminate\Database\Seeder;
use App\Models\Site\Endereco;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Endereco::create([
    			'CEP'						=> '99.999-999',
    			'Logradouro'				=> 'Quadra 99 Conjunto 99 Casa 99',
    			'Bairro'					=> 'Vila do 999999',
    			'Cidade'					=> 'Teste 99 do 99999',
    			'UFs_idUFs'					=> '2'
    	]);
    	
    	User::create([
    			'first_name'				=> 'Recepçao',
    			'last_name'					=> ' ',
    			'email'						=> 'recepcao@bratech.com',
    			'password'					=> bcrypt('123456'),
    			'gender'					=> 'M',
    			'TipoMembros_idTipoMembros'	=>'1',
    			'Enderecos_idEnderecos'		=>'1',
    			'Igrejas_idIgrejas'			=>'1'
    	]);//1
    	
    	User::create([
    			'first_name'				=> 'Gestor',
    			'last_name'					=> 'Eventos',
    			'email'						=> 'eventos@bratech.com',
    			'password'					=> bcrypt('123456'),
    			'gender'					=> 'M',
    			'TipoMembros_idTipoMembros'	=>'1',
    			'Enderecos_idEnderecos'		=>'1',
    			'Igrejas_idIgrejas'			=>'1'
    	]);//2
    	
    	User::create([
    			'first_name'				=> 'Supervisor',
    			'last_name'					=> 'Célula',
    			'email'						=> 'supervisor@bratech.com',
    			'password'					=> bcrypt('123456'),
    			'gender'					=> 'M',
    			'TipoMembros_idTipoMembros'	=>'1',
    			'Enderecos_idEnderecos'		=>'1',
    			'Igrejas_idIgrejas'			=>'1'
    	]);//3
    	
    	User::create([
    			'first_name'				=> 'Lider',
    			'last_name'					=> 'Célula',
    			'email'						=> 'lider@bratech.com',
    			'password'					=> bcrypt('123456'),
    			'gender'					=> 'M',
    			'TipoMembros_idTipoMembros'	=>'1',
    			'Enderecos_idEnderecos'		=>'1',
    			'Igrejas_idIgrejas'			=>'1'
    	]);//4
    	
    	User::create([
    			'first_name'				=> 'Secretario',
    			'last_name'					=> '(a)',
    			'email'						=> 'secretariado@bratech.com',
    			'password'					=> bcrypt('123456'),
    			'gender'					=> 'M',
    			'TipoMembros_idTipoMembros'	=>'1',
    			'Enderecos_idEnderecos'		=>'1',
    			'Igrejas_idIgrejas'			=>'1'
    	]);//5
    	
    	User::create([
    			'first_name'				=> 'Pastor',
    			'last_name'					=> '(a)',
    			'email'						=> 'pastorado@bratech.com',
    			'password'					=> bcrypt('123456'),
    			'gender'					=> 'M',
    			'TipoMembros_idTipoMembros'	=>'1',
    			'Enderecos_idEnderecos'		=>'1',
    			'Igrejas_idIgrejas'			=>'1'
    	]);//6
    	
    	User::create([
    			'first_name'				=> 'Administrador',
    			'last_name'					=> '(a)',
    			'email'						=> 'admin@bratech.com',
    			'password'					=> bcrypt('123456'),
    			'gender'					=> 'M',
    			'TipoMembros_idTipoMembros'	=>'1',
    			'Enderecos_idEnderecos'		=>'1',
    			'Igrejas_idIgrejas'			=>'1'
    	]);//7
    	
    }
}
