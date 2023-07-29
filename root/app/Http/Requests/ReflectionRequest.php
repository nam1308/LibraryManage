<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReflectionRequest extends FormRequest
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
            'rate' => ['required'],
            'note' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'rate' => [
                'required' => 'Vui lòng đánh giá sao.',
            ],
            'note' => [
                'required' => 'Vui lòng nhập nội dung.',
            ],
        ];
    }
}