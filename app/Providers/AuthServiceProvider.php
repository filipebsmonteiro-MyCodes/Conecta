<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
	protected $policies = [
			'App\Model'			=> 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        //Quando artisan, não necessita permissao
        if ( request()->server->get("SCRIPT_NAME") != 'artisan' ) {
        	$this->registerPermissions();
        }
        
    }
    
    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function registerPermissions()
    {
    	Gate::before(function(User $user, $ability){
    		if ( $user->hasAnyPerfils('admin') )
    			return true;
    	});
    	
    	// Dinamicamente registra permissoes com Gates do Laravel.
    	$permissoes = \App\Models\Site\Permissao::with('perfils')->get();
    	foreach ($permissoes as $permission) {
    		Gate::define($permission->name, function (User $user) use ($permission) {
    			return $user->hasPermissao($permission);
    		});
    	}
    		
    	/* Verifica se a entidade Acessada
    	   é da mesma igreja do user Logado */
    	Gate::define('mesma-igreja', function (User $user, $idIgreja) {
    		return $user->Igrejas_idIgrejas == $idIgreja;
    	});
    }
}
