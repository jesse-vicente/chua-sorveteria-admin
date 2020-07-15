<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'cliente'               => 'required|min:3|max:50',
            'apelido'               => 'nullable|max:50',
            'endereco'              => 'required|max:50',
            'numero'                => 'required|gt:0',
            'complemento'           => 'nullable|max:50',
            'bairro'                => 'required|max:50',
            'cep'                   => 'required|size:9',
            'cidade_id'             => 'required|exists:cidades,id',
            'condicao_pagamento_id' => 'required|exists:condicoes_pagamento,id',
            'telefone'              => 'nullable|max:15',
            'whatsapp'              => 'required|max:15',
            'email'                 => 'nullable|email|max:50',
            'data_nascimento'       => 'required|date|date_format:Y-m-d|before:-15 years',
            'observacoes'           => 'nullable|min:5|max:255',

            'cpf'                   => [
                'required',
                'cpf',
                Rule::unique('clientes')->ignore($this->request->get('id'))
            ],
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'cidade_id.exists'       => 'Código inválido.',
            'data_nascimento.before' => 'O cliente deve ser maior de 15 de anos.',
            'observacoes.min'        => 'O campo observações deve ter pelo menos 5 caracteres.',
            'observacoes.max'        => 'O campo observações não pode ser superior a 255 caracteres.',
        ];
    }
}
