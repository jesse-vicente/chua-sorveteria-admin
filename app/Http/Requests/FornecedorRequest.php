<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends FormRequest
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
            'fornecedor'            => 'required|min:3|max:50',
            'nome_fantasia'         => 'nullable|max:50',
            'endereco'              => 'required|max:50',
            'numero'                => 'required|gt:0',
            'complemento'           => 'nullable|max:50',
            'bairro'                => 'required|max:50',
            'cep'                   => 'required|size:9',
            'cidade_id'             => 'required|exists:cidades,id',
            'condicao_pagamento_id' => 'required|exists:condicoes_pagamento,id',
            'telefone'              => 'nullable|max:15',
            'whatsapp'              => 'nullable|max:15',
            'email'                 => 'nullable|email|max:50',
            'website'               => 'nullable|url|max:50',
            'contato'               => 'nullable|max:20',
            'valor_credito'         => 'nullable|gt:0',
            'observacoes'           => 'nullable|min:5|max:255',

            'cpf_cnpj' => [
                'required',
                'cpf_cnpj',
                Rule::unique('fornecedores')->ignore($this->request->get('id'))
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
            'cidade_id.exists'              => 'Código inválido.',
            'condicao_pagamento_id.exists'  => 'Código inválido.',
            'observacoes.min'               => 'O campo observações deve ter pelo menos 5 caracteres.',
            'observacoes.max'               => 'O campo observações não pode ser superior a 255 caracteres.',
        ];
    }
}
