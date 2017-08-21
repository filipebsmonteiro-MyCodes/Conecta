<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Restricao extends Model
{
	protected $fillable = [
			'idade_Minima',
			'idade_Maxima',
			'genero',
			'EstadoCivils_idEstadoCivils',
			'Eventos_idEventos'
	];
}
