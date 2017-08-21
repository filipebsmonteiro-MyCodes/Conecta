<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class PresencaCelulaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        		'User_has_Celulas_idUser_has_Celulas'	=> '',
        		'Celulas_idCelulas'						=> '',
        		'Data_Encontro'							=> ''
        ];
    }
}
