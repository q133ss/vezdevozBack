<?php

namespace App\Http\Requests\TaskController;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            //'position' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Название должно быть строкой',
//            'position.required' => 'Укажите позицию',
//            'position.integer' => 'Позиция должна быть числом'
        ];
    }
}
