<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstadoRequest extends FormRequest
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
            'estado' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('estados')->ignore($this->request->get('id'))
            ],

            'uf' => [
                'required',
                'alpha',
                'min:2',
                'max:3',
                Rule::unique('estados')->ignore($this->request->get('id'))
            ],

            'pais_id' => 'required|exists:paises,id',
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
            'pais_id.exists' => 'Código inválido.',
        ];
    }
}
