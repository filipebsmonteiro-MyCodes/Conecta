<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Site\Permissao;
use App\Models\Site\Perfil;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //Retorna os Perfis que Possuem aquelaPermissao 
    public function perfils()
    {
    	return $this->belongsToMany(Perfil::class, 'user_has_perfils', 'Users_idUsers', 'Perfils_idPerfils');
    }
    
    public  function hasPermissao(Permissao $permissao)
    {
    	//dd($permissao->perfils());
    	// Retorna os perfis que Possuem a permissao especifica
    	return $this->hasAnyPerfils($permissao->perfils());
    }
    
    public function hasAnyPerfils($perfils)
    {
    	
    	$perfisUser			= $this->perfils()->get();
    	if ( is_array($perfils) || is_object($perfils) ) {
    		
    		$perfisAutorizados	= $perfils->get();
    		//dd($perfisAutorizados->intersect($perfisUser)->count());
    		return !! $perfisAutorizados->intersect($perfisUser)->count();
    		
    	}
    	
    	return $this->perfils()->get()->contains('name', $perfils);
    }
}
