<?php

namespace App\Imports;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Rules\UniqueUser;
use App\Enums\UserEnums;
use App\Rules\UniqueCategory;
use App\Enums\CategoryEnums;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Jobs\Admin\ProcessBooksImport;

class BooksImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param \Maatwebsite\Excel\Row $row
     */

    public function collection(\Illuminate\Support\Collection $collection)
    {
        $rowData = $collection->toArray();
        dispatch(new ProcessBooksImport($rowData));
    }

    public function rules(): array
    {
        return [
            '*.book_cd' => ['required', 'max:20', 'regex:/^DX.*/'],
            '*.name' => ['required', 'max:50'],
            '*.quantity' => ['required', 'max:20', 'integer'],
            '*.author' => ['required', 'max:50'],
            '*.user_id' => [
                'required',
                'integer',
                new UniqueUser(UserEnums::PARAM_RULE_ID),
            ],
            '*.cate_1' => [
                'required',
                'integer',
                new UniqueCategory(CategoryEnums::PARAM_RULE_ID),
            ],
            '*.cate_2' => [
                'required',
                'integer',
                new UniqueCategory(CategoryEnums::PARAM_RULE_ID),
            ],
            '*.cate_3' => [
                'required',
                'integer',
                new UniqueCategory(CategoryEnums::PARAM_RULE_ID),
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.*.required' => 'Vui lòng nhập :attribute',
            '*.*.regex' => 'Vui lòng nhập :attribute theo định dạng DX...',
            '*.*.max' => 'Vui lòng nhập :attribute ít hơn :max ký tự.',
            '*.*.integer' => 'Vui lòng nhập :attribute là kiểu số nguyên.',
        ];
    }
}
