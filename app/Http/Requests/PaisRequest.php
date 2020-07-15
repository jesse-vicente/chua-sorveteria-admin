<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'pais'  => 'required|min:3|max:50',
            'sigla' => 'required|alpha|min:2|max:3',
            'ddi'   => 'required|numeric|gt:0|lt:1000',
        ];
    }
}
