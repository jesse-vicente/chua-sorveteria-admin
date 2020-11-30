<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaPagarRequest extends FormRequest
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
            'fornecedor_id'      => 'required|exists:fornecedores,id',
            'forma_pagamento_id' => 'required|exists:formas_pagamento,id',
            'juros'              => 'nullable|gt:0',
            'multa'              => 'nullable|gt:0',
            'desconto'           => 'nullable|gt:0',
            'data_emissao'       => 'required|date|date_format:Y-m-d|before_or_equal:data_vencimento',
            'data_vencimento'    => 'required|date|date_format:Y-m-d|after_or_equal:data_emissao',
            'data_pagamento'     => 'nullable|date|date_format:Y-m-d|after_or_equal:data_emissao',
            'valor_pago'         => 'nullable|gt:0',
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
            'valor_pago.gt' => 'O valor pago deve ser maior que 0.',
            'juros.gte'     => 'O valor dos juros não pode ser inferior a 0.',
            'multa.gte'     => 'O valor da multa não pode ser inferior a 0.',
            'desconto.gte'  => 'O valor do desconto não pode ser inferior a 0.',
            'desconto.lt'   => 'O valor do desconto deve ser inferior ao valor pago.',
        ];
    }
}
