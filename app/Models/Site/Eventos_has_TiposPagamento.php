<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Eventos_has_tiposPagamento extends Model
{
    protected $fillable = [
    		'Eventos_idEventos',
    		'idTipos_Pagamentos'
    ];
}
