<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ConvidadoFormRequest extends FormRequest
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
        	'nome'					=> 'required|min:3|max:30',
        	'email'					=> 'nullable|email|max:70',
        	'data_nascimento'		=> 'date',
        	'genero'				=> 'max:1',
        	'celular'				=> 'max:16',
        	'discipulador'			=> 'max:30',
        	'Regiaos_idRegiaos'		=> 'exists:regiaos,id'
        ];
    }
}
