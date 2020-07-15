<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
            'produto'             => 'required|min:2|max:50',
            'categoria_id'        => 'required|exists:categorias,id',
            'fornecedor_id'       => 'required|exists:fornecedores,id',
            'unidade'             => 'required|max:10',
            'estoque'             => 'nullable',
            'preco_custo'         => 'nullable|gt:0',
            'preco_venda'         => 'required|gt:0',
            'custo_ultima_compra' => 'nullable|gt:0',
            'data_ultima_compra'  => 'nullable|date|date_format:Y-m-d',
            'data_ultima_venda'   => 'nullable|date|date_format:Y-m-d',
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
            'categoria_id.exists'  => 'Código inválido.',
            'fornecedor_id.exists' => 'Código inválido.',
        ];
    }
}
