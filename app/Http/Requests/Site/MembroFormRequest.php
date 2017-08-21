<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class MembroFormRequest extends FormRequest
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
        		'email'							=> 'nullable|email|max:70',
        		'password'						=> 'nullable|max:150',
        		'first_name'					=> 'required|max:30',
        		'last_name'						=> 'nullable|max:30',
        		'nickname'						=> 'nullable|max:30',
        		
        		'EstadoCivils_idEstadoCivils'	=> 'nullable|exists:Estado_Civils,id',
        		'birthday'						=> 'nullable|date',
        		'gender'						=> 'required',
        		
        		'phone'							=> 'nullable|max:16',
        		'mobile'						=> 'nullable|max:16',
        		'CPF'							=> 'nullable|max:14',
        		'RG'							=> 'nullable|max:20',
        		'Emissor'						=> 'nullable|max:10',
        		'Enderecos_idEnderecos'			=> 'nullable',
        		
        		'TipoMembros_idTipoMembros'		=> 'required|exists:Tipo_Membros,id',
        		'TipoEntradas_idTipoEntradas'	=> 'nullable|exists:Tipo_Entradas,id',
        		'DataEntrada'					=> 'nullable|date',
        		'IgrejaDeOrigem'				=> 'nullable|max:30',
        		
        		'Celulas_idCelulas'				=> 'nullable|exists:Celulas,id',
        		
        		'idFoto'						=> 'nullable|max:20',
        		'Ativo'							=> 'required',
        		'Users_idDiscipulador'			=> 'nullable|exists:users,id'
        ];
    }
}
