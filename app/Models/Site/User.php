<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
	use SoftDeletes;
	
	protected $fillable =[
    		'email', 
    		'password', 
    		'first_name', 
    		'last_name',
			'nickname',
    		'EstadoCivils_idEstadoCivils',
    		'birthday', 
    		'gender',
    		
    		'phone', 
    		'mobile', 
    		'CPF', 
    		'RG', 
    		'Emissor',
    		'Enderecos_idEnderecos',
    		
    		'TipoMembros_idTipoMembros',
    		'TipoEntradas_idTipoEntradas',
    		'DataEntrada', 
    		'IgrejaDeOrigem',
    		
    		'idFoto',
			'Users_idDiscipulador',
			'Igrejas_idIgrejas'
    ];
}
