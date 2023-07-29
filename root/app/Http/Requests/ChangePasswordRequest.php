<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password'=>['required', new MatchOldPassword],
            'new_password'=>[
                        'required',
                        'min:8',
                        'confirmed',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*#?&]/', 
                        ],
            'new_password_confirmation'=>['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'current_password.required'=>':attribute không được để trống.',

            'new_password' => [
                'required' => ':attribute phải được điền.',
                'min'      => ':attribute phải lớn hơn 8 kí tự.',
                'confirmed'=> ':attribute và mật khẩu xác nhận phải trùng nhau.',
                'regex'=> ':attribute phải bao gồm cả số, chữ thường và hoa, ký tự đặc biệt.',
            ],

            'new_password_confirmation' => [
                'required' => ':attribute phải được điền.',
                'min'      => ':attribute phải lớn hơn 8 kí tự.',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'current_password'=> 'Mật khẩu hiện tại',
            'new_password'=> 'Mật khẩu mới',
            'new_password_confirmation'=> 'Mật khẩu xác nhận',
        ];
    }
}
