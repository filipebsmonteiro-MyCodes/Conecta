<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class User_has_perfil extends Model
{
    protected $fillable = [
    		'Users_idUsers',
    		'Perfils_idPerfils'
    ];
}
