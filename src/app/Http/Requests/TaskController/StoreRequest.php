<?php

namespace App\Http\Requests\TaskController;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|string',
            'position' => 'sometimes|integer',
            'column_id' => 'required|exists:columns,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Укажите имя',
            'name.string'   => 'Имя должно быть строкой',

            'position.integer' => 'Позиция должна быть числом',

            'column_id.required' => 'Укажите колонку',
            'column_id.exists'   => 'Указанной колонки не существует'
        ];
    }
}
