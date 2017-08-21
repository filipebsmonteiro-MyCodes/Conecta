<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
    		'Nome',
    		'Inicio',
    		'Final',
    		'Local',
    		'Quantidade_Vagas',
    		'Nome_Banco',
    		'Agencia',
    		'Conta',
    		'Tipo_Conta',
    		'Cpf_Cnpj',
    		'Nome_Beneficiario',
    		'Email_PagSeguro',
    		'Token_PagSeguro',
    		'Igrejas_idIgrejas',
    		'Ativo'
    ];
    
    public function tipos_pagamentos() {
    	return $this->belongsToMany(TiposPagamento::class, 'Eventos_has_tipos_pagamentos', 'Eventos_idEventos', 'idTipos_Pagamentos');
    }
}
