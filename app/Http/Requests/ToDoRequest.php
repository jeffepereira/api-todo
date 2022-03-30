<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToDoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'nullable|max:500',
        ];
    }

    public function messages()
    {
        return [
            'max' => 'Limite o campo a no máximo :max caracteres.',
            'title.required' => 'Forneça um título para a tarefa.',
        ];
    }
}
