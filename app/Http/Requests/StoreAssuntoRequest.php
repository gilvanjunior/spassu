<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssuntoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Defina como true para permitir o acesso ao request
    }

    public function rules()
    {
        return [
            'descricao' => 'required|string|max:40',
        ];
    }
    public function messages()
    {
        return [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.string' => 'O campo descrição deve ser um texto.',
            'descricao.max' => 'O campo descrição não pode ter mais que 40 caracteres.',
        ];
    }
}
