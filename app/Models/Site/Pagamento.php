<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [
    		'Users_has_Eventos_idUsers_has_Eventos',
    		'Tipos_Pagamentos_idTipos_Pagamentos',
    		'Status_Pagamentos_idStatus_Pagamentos',
    		'Comentario',
    		'Valor_Liquido',
    		'Valor_Bruto',
    		'Codigo'
    ];
    
    public function status() {
    	return $this->hasOne(StatusPagamento::class, 'id', 'Status_Pagamentos_idStatus_Pagamentos');
    }
    
    public function inscricao() {
    	return $this->hasOne(User_has_evento::class, 'id', 'Users_has_Eventos_idUsers_has_Eventos');;
    }
}
