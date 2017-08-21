<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Celula extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    		'Nome',
    		'Enderecos_idEnderecos',
    		'Ativa',
    		'Redes_idRedes',
    		'Regiaos_idRegiaos',
    		'Igrejas_idIgrejas'
    ];
    
    /**
     * Método valida se user logado é lider da Célula informada
     * 
     * @param int $idCelula
     * @return boolean
     */
    public function is_Lider($idCelula) 
    {
    	$UC		= new User_has_celula();
    	
    	$return	= $UC->where('Celulas_idCelulas', $idCelula)
				    ->where('Users_idUsers', auth()->user()->id)
				    ->where('cargo', 'Lider')
    				->first();
    	
    	if (empty($return) && !auth()->user()->hasAnyPerfils('admin')) {
    		return false; 
    	}else {
    		return true;
    	}
    	
    }
    
    /**
     * Método valida se user logado é Supervisor(a) da Célula informada
     * 
     * @param int $idCelula
     * @return boolean
     */
    public function is_Super($idCelula) 
    {
    	$rede	= new Rede();
    	$celula	= $this->find($idCelula);
    	
    	$redes	= $rede->where('Users_idSupervisor', auth()->user()->id)->get();
    	foreach ($redes as $rede) {
    		if ($rede->id == $celula->Redes_idRedes) {
    			return true;
    		}
    	}
    	
    	return false; 
    }
    
}
