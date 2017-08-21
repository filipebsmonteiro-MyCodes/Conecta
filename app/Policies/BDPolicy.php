<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Site\Permissao;

class BDPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    	//Recupera TODAS as Permissoes cadastradasno BD
    	$permissoes = Permissao::with('perfils')->get();
    	foreach ($permissoes as $permissao) {
    		
    		Gate::define($permissao->name, function(User $user) use ($permissao){
    			return $user->hasPermissao($permissao);
    		});
    			
    	}
    }
}
