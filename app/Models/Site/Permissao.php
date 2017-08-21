<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    public function perfils() 
    {
    	return $this->belongsToMany(Perfil::class, 'perfil_has_permissaos', 'Permissaos_idPermissaos', 'Perfils_idPerfils');
    }
}
