<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rede extends Model
{
	use SoftDeletes;
	
	protected $fillable =[
			'Nome',
			'Ativa',
			'Users_idSupervisor',
			'Igrejas_idIgrejas'
	];
	
	public function celulas() 
	{
		return $this->hasMany(Celula::class, 'Redes_idRedes');
	}
	
	public function is_Super($idRede) 
	{	
		$return	= $this	->where('id', $idRede)
						->where('Users_idSupervisor', auth()->user()->id)
						->first();
		
		if ( empty($return) && !auth()->user()->hasAnyPerfils('admin')) {
			return false;
		}else {
			return true;
		}
	}
}
