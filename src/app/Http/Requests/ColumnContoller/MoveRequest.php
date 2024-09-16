<?php

namespace App\Http\Requests\ColumnContoller;

use Illuminate\Foundation\Http\FormRequest;

class MoveRequest extends FormRequest
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
            'target_position' => 'required|integer',
            'target_column_id' => 'required|exists:columns,id'
        ];
    }

    public function messages(): array
    {
        return [
            'target_position.required' => 'Укажите позицию',
            'target_position.integer' => 'Позиция должна быть числом',

            'target_column_id.required' => 'Укажите колонку',
            'target_column_id.exists' => 'Указанной колонки не существует'
        ];
    }
}
