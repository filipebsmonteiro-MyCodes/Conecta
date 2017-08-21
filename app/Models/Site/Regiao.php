<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regiao extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
			'nome',
			'Igrejas_idIgrejas'
			
	];
}
