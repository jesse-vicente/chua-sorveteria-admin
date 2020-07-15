<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioRequest extends FormRequest
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
            'funcionario'     => 'required|min:3|max:50',
            'apelido'         => 'nullable|max:50',
            'sexo'            => 'required|max:10',
            'endereco'        => 'required|max:50',
            'numero'          => 'required|gt:0',
            'complemento'     => 'nullable|max:50',
            'bairro'          => 'required|max:50',
            'cep'             => 'required|size:9',
            'cidade_id'       => 'required|exists:cidades,id',
            'cidade'          => 'required',
            'telefone'        => 'nullable|max:15',
            'whatsapp'        => 'required|max:15',
            'email'           => 'nullable|email|max:50',
            'cpf'             => 'required|cpf',
            'rg'              => 'required',
            'salario'         => 'required|numeric|gt:0',
            'data_nascimento' => 'required|date|date_format:Y-m-d|before:-18 years',
            'data_admissao'   => 'required|date|date_format:Y-m-d|before:tomorrow',
            'data_demissao'   => 'nullable|date|date_format:Y-m-d|after:data_admissao',
            'observacoes'     => 'nullable|min:5|max:255'
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
            'data_nascimento.before' => 'O funcionário deve ser maior de 18 de anos.',
            'data_admissao.before'   => 'A data de admissão não pode ser uma data futura.',
            'data_demissao.after'    => 'A data de demissão deve ser posterior a data de admissão.',
            'observacoes.min'        => 'O campo observações deve ter pelo menos 5 caracteres.',
            'observacoes.max'        => 'O campo observações não pode ser superior a 255 caracteres.',
        ];
    }
}
