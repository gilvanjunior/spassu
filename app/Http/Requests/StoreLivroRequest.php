<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivroRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Defina como true para permitir o acesso ao request
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.string' => 'O campo título deve ser um texto.',
            'titulo.max' => 'O título não pode ter mais que 255 caracteres.',

            'preco.required' => 'O campo preço é obrigatório.',
            'preco.numeric' => 'O campo preço deve ser um número.',
            'preco.min' => 'O preço deve ser um valor positivo.',
        ];
    }
}
