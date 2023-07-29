<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeInfoUserRequest extends FormRequest
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
            'name'=>['required', 'max:30'],
            'email'=>['required', 'max:50', 'email', Rule::unique('users', 'email')->ignore(auth()->user()->id)->whereNull('deleted_at'), config('constants.EMAIL_REGEX')],
            'address'=>[ 'max:100'],
            'note'=>['max:255'],
            'birthday'=>['required'],
            'gender'=>['required'],
            'avatar'=>['image', 'max:1024', 'mimes:jpg,png,jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                'required' => 'Vui lòng nhập nội dung.',
                'max'      => 'Vui lòng nhập ít hơn 30 ký tự.',
            ],
            'email' => [
                'required' => 'Vui lòng nhập nội dung.',
                'max'      => 'Vui lòng nhập ít hơn 50 ký tự.',
                'email'     => 'Vui lòng nhập đúng định dạng email.',
                'unique'     => 'Email đã được sử dụng vui lòng nhập Email khác',
                'regex'     => 'Vui lòng nhập đúng định dạng email.',
            ],
            'address' => [
                'max'      => 'Vui lòng nhập ít hơn 100 ký tự.',
            ],
            'birthday' => [
                'required' => 'Vui lòng nhập nội dung.',
            ],
            'gender' => [
                'required' => 'Vui lòng nhập nội dung.',
            ],
            'note' => [
                'max'      => 'Vui lòng nhập ít hơn 255 ký tự.',
            ],
            'avatar' => [
                'image'      => 'Vui lòng chọn định dạng ảnh.',
                'mimes'      => 'Vui lòng chọn định dạng ảnh.',
                'max'      => 'Vui lòng chọn ảnh nhỏ hơn 1MB.',
            ],
        ];
    }
}
