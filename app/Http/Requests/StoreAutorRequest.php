<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAutorRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Defina como true para permitir o acesso ao request
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:40',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.max' => 'O campo nome não pode ter mais que 40 caracteres.',
        ];
    }
}
