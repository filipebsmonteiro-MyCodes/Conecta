<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
    		'CEP',
    		'Logradouro',
    		'Bairro',
    		'Cidade',
    		'UFs_idUFs'
    ];
}
