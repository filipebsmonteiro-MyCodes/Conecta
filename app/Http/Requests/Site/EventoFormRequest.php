<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class EventoFormRequest extends FormRequest
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
        		'Nome'				=> 'required|min:3|max:45',
        		'Inicio'			=> 'required|date',
        		'Final'				=> 'required|date',
        		'Local'				=> 'required|min:3|max:45',
        		'Quantidade_Vagas'	=> 'required|numeric',
        		'Nome_Banco'		=> 'nullable|min:3|max:30',
        		'Agencia'			=> 'nullable|min:3|max:20',
        		'Conta'				=> 'nullable|min:3|max:20',
        		'Tipo_Conta'		=> 'nullable|min:3|max:20',
        		'Cpf_Cnpj'			=> 'nullable|min:3|max:20',
        		'Nome_Beneficiario'	=> 'nullable|min:3|max:30',
        		'Email_PagSeguro'	=> 'nullable|min:3|max:70',
        		'Token_PagSeguro'	=> 'nullable|min:3|max:32',
        		'Ativo'				=> 'required|max:1'
        ];
    }
}
