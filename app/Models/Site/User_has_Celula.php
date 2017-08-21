<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_has_celula extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
			'Users_idUsers',
			'Convidados_idConvidados',
    		'Celulas_idCelulas',
    		'cargo',
			'deleted_at'
    ];
}
