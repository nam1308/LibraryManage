<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            //
            'employee_id' => 'required|max:30|unique:users,employee_id,NULL,id,deleted_at,NULL',
            'email' => ["required", "email","max:50", "unique:users,email,NULL,id,deleted_at,NULL", config('constants.EMAIL_REGEX')],
            'name' => 'required|max:30',
            'gender' => 'required',
            'birthday' => 'required|date',
            'address' => 'max:100',
            'avatar' => 'required|image|max:1024',
            'note' => 'max:255',
            'department_id' => 'required',
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
            'employee_id.unique' => 'Mã nhân viên đã tồn tại',
            'email.unique' => 'Email đã tồn tại',
            'required' => 'Vui lòng nhập nội dung',
            'name.max' => 'Vui lòng nhập ít hơn 30 ký tự',
            'employee_id.max' => 'Vui lòng nhập ít hơn 30 ký tự',
            'avatar.required' => 'Vui lòng nhập nội dung',
            'avatar.max' => 'Vui lòng nhập ít hơn 1 MB',
            'avatar.image' => 'Vui lòng nhập đúng định dạng ảnh',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'email.regex' => 'Vui lòng nhập đúng định dạng email',
            'email.max' => 'Vui lòng nhập ít hơn 50 ký tự',
            'gender.date_format' => 'Vui lòng nhập đúng định dạng dd-mmm-yyyy',
            'address.max' => 'Vui lòng nhập ít hơn 100 ký tự',
            'note.max' => 'Vui lòng nhập ít hơn 255 ký tự',
            'birthday.date' => 'Vui lòng chọn ngày',
        ];
    }
}
