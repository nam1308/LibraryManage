<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ImportBookRequest extends FormRequest
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
            'fileCsv' => 'required|mimes:csv,txt|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'fileCsv.required' => 'Vui lòng chọn file',
            'fileCsv.mimes' => 'Vui lòng nhập đúng định dạng file csv/txt',
            'fileCsv.max' => 'Vượt quá kích thước tối đa là 2MB',
        ];
    }
}
