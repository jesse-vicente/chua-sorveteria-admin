<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class VendaRequest extends FormRequest
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
            'modelo'   => 'required|numeric|gt:0',
            'serie'    => 'required|numeric|gt:0',

            'num_nota' => [
                'required',
                'numeric',
                'gt:0',
                'lt:999999',
                Rule::unique('vendas')
                    ->where('serie',  $this->request->get('serie'))
                    ->where('modelo', $this->request->get('modelo'))
                    ->where('cliente_id', $this->request->get('cliente_id'))
            ],

            'cliente_id' => 'required|exists:clientes,id',

            'condicao_pagamento_id' => 'required|exists:condicoes_pagamento,id',

            'total_venda' => 'gt:0',
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
            'modelo.required' => 'Informe o modelo da nota.',
            'modelo.gt'       => 'O modelo da nota deve ser maior que 0.',

            'serie.required'  => 'Informe a série da nota.',
            'serie.gt'        => 'A série da nota deve ser maior que 0.',

            'num_nota.required' => 'Informe o número da nota.',
            'num_nota.gt'       => 'O número da nota deve ser maior que 0.',
            'num_nota.lt'       => 'O número da nota deve ser menor que 999999.',
            'num_nota.unique'   => 'O número da nota já está sendo utilizado.',

            'cliente_id.exists' => 'Código do cliente inválido.',
            'cliente_id.required' => 'Informe o cliente.',

            'condicao_pagamento_id.exists' => 'Código da condição de pagamento inválido.',
            'condicao_pagamento_id.required' => 'Informe a condição de pagamento.',

            'total_venda.gt' => 'Selecione o(s) produto(s) da venda.'
        ];
    }
}
