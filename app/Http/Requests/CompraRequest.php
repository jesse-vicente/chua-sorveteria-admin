<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompraRequest extends FormRequest
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
                Rule::unique('compras')
                    ->where('serie',  $this->request->get('serie'))
                    ->where('modelo', $this->request->get('modelo'))
                    ->where('fornecedor_id', $this->request->get('fornecedor_id'))
            ],

            'fornecedor_id' => 'required|exists:fornecedores,id',
            // 'fornecedor'    => 'required',

            // 'produto_id' => 'required|exists:produtos,id',
            // 'produto'    => 'required',

            'data_emissao' => 'required|date|date_format:Y-m-d|before_or_equal:data_chegada',
            'data_chegada' => 'required|date|date_format:Y-m-d|after_or_equal:data_emissao',
            // 'produtos' => 'required',

            // 'total_produtos' => 'gt:0',

            'condicao_pagamento_id' => 'required|exists:condicoes_pagamento,id',
            // 'condicao_pagamento'    => 'required',

            'total_compra' => 'gt:0',
            'total_compra' => 'lte:limite_credito',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        $totalCompra = number_format($this->request->get('total_compra'), 2, ',', '.');
        $limiteCredito = number_format($this->request->get('limite_credito'), 2, ',', '.');

        return [
            'modelo.required' => 'Informe o modelo da nota.',
            'modelo.gt'       => 'O modelo da nota deve ser maior que 0.',

            'serie.required'  => 'Informe a série da nota.',
            'serie.gt'        => 'A série da nota deve ser maior que 0.',

            'num_nota.required' => 'Informe o número da nota.',
            'num_nota.gt'       => 'O número da nota deve ser maior que 0.',
            'num_nota.lt'       => 'O número da nota deve ser menor que 999999.',
            'num_nota.unique'   => 'O número da nota já está sendo utilizado.',

            'data_emissao.before_or_equal' => 'A Data de Emissão deve ser anterior ou igual a Data de Chegada.',
            'data_chegada.after_or_equal'  => 'A Data de Chegada deve ser posterior ou igual a Data de Emissão.',

            'fornecedor_id.exists' => 'Código do fornecedor inválido.',
            'fornecedor_id.required' => 'Informe o fornecedor.',

            'condicao_pagamento_id.exists' => 'Código da condição de pagamento inválido.',
            'condicao_pagamento_id.required' => 'Informe a condição de pagamento.',

            'total_compra.gt' => 'Selecione o(s) produto(s) da compra.',
            'total_compra.lte' => "O total da compra (R$ $totalCompra) é maior que o limite de crédito permitido (R$ $limiteCredito).",
        ];
    }
}
