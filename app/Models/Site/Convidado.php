<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Convidado extends Model
{
    protected $fillable = [
    		'nome',
    		'email',
    		'data_nascimento',
    		'genero',
    		'celular',
    		'discipulador',
    		'Regiaos_idRegiaos',
    		'Igrejas_idIgrejas'
    ];
}
