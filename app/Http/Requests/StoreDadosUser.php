<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDadosUser extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'password' => 'required|string|min:8|confirmed',
           'idade' => 'required|integer',
           'peso' => 'required|numeric',
           'altura' => 'required|numeric',
           'sexo' => 'required|string|max:10',
           'objetivo_peso' => 'required|numeric',
           'data_objetivo' => 'required|date',
        ];
    }
}
