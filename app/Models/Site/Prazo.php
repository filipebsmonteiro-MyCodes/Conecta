<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Prazo extends Model
{
	protected $fillable = [
			'Eventos_idEventos',
			'Prazo_Data',
			'Prazo_Valor',
	];
}
