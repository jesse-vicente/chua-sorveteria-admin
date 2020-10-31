<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaReceberRequest extends FormRequest
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
            'cliente_id'         => 'nullable|exists:clientes,id',
            'forma_pagamento_id' => 'required|exists:formas_pagamento,id',
            'data_vencimento'    => 'required|date|date_format:Y-m-d|after_or_equal:data_venda',
            'data_pagamento'     => 'required|date|date_format:Y-m-d|before_or_equal:today',
            'valor_pago'         => 'required|gt:0',
        ];
    }
}
