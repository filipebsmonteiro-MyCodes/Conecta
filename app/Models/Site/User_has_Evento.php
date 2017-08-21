<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use App\User;

class User_has_evento extends Model
{
    protected $fillable = [
    		'Users_idUsers',
    		'Eventos_idEventos'
    ];
    
    public function user() {
    	return $this->hasOne(User::class, 'id', 'Users_idUsers');
    }
    
    public function evento() {
    	return $this->hasOne(Evento::class, 'id', 'Eventos_idEventos');
    }
    
    public function pagamento() {
    	return $this->hasOne(Pagamento::class, 'Users_has_Eventos_idUsers_has_Eventos', 'id');
    }
}
