<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginUserRequest extends FormRequest
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
            'email'=>['required', 'max:50', 'email', config('constants.EMAIL_REGEX')],
            'password'=>['required'],
        ];
    }

    public function messages()
    {
        return [
            'email' => [
                'required' => 'Vui lòng nhập nội dung.',
                'min'      => 'Vui lòng nhập ít hơn 50 ký tự.',
                'email'     => 'Vui lòng nhập đúng định dạng email.',
                'regex' => 'Vui lòng nhập đúng định dạng email',
            ],
            'password' => [
                'required' => 'Vui lòng nhập nội dung.',
            ],
        ];
    }
}
