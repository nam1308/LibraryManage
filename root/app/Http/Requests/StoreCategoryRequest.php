<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'category_cd' => 'required|max:20|unique:categories,category_cd,NULL,id,deleted_at,NULL',
            'name' => 'required|max:50|unique:categories,name,NULL,id,deleted_at,NULL',
            'status' => 'required',
            'note' => 'max:255',
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
            'required' => 'Vui lòng nhập nội dung',
            'category_cd.max' => 'Vui lòng nhập ít hơn 20 ký tự',
            'category_cd.unique' => 'Mã thể loại đã tồn tại',
            'name.max' => 'Vui lòng nhập ít hơn 50 ký tự',
            'name.unique' => 'Tên thể loại đã tồn tại',
            'note.max' => 'Vui lòng nhập ít hơn 255 ký tự',
        ];
    }
}
