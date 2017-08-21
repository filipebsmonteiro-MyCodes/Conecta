<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class PresencaCelula extends Model
{
	protected $fillable = [
			'Celulas_idCelulas',
			'User_has_Celulas_idUser_has_Celulas',
			'Data_Encontro'
	];
}
