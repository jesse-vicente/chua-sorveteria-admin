<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class PaisRequest extends FormRequest
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
            'pais' => [
                'required',
                'min:3',
                'max:50',
                'regex:/^[\pL\s\-]+$/u',
                Rule::unique('paises')->ignore($this->request->get('id'))
            ],

            'sigla' => [
                'required',
                'min:2',
                'max:3',
                'alpha',
                Rule::unique('paises')->ignore($this->request->get('id'))
            ],

            'ddi' => [
                'required',
                'numeric',
                'gt:0',
                Rule::unique('paises')->ignore($this->request->get('id'))
            ],
        ];
    }
}
