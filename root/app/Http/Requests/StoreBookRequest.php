<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Rules\UniqueBookCodeAndName;
use App\Enums\BookEnums;
use App\Models\Book;
use App\Rules\CheckUserActive;
use App\Rules\CheckCategoryActive;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        $routeName = \Route::currentRouteName();
        $imageRule = 'required|image|max:1024';
        $ignoreValidation = false;
        $statusUniqueName = Rule::unique('books', 'name')->ignore($request->id)->whereNull('deleted_at');
        $statusUniqueBookCd = Rule::unique('books', 'book_cd')->ignore($request->id);

        if ($routeName == 'admin.books.create' && $request->book_cd && $request->name) {
            $book = Book::where(['book_cd' => $request->book_cd, 'name' => $request->name])->first();

            if ($book) {
                $imageRule = 'sometimes|image|max:1024';
            }
            $ignoreValidation = true;
            $statusUniqueName = new UniqueBookCodeAndName(BookEnums::PARAM_RULE_NAME);
            $statusUniqueBookCd = new UniqueBookCodeAndName(BookEnums::PARAM_RULE_BOOK_CD);

        }  elseif ($routeName == 'admin.books.update') {
            $imageRule = 'sometimes|image|max:1024';
            $fromDetailScreen = $request->isDetail;

            if ($fromDetailScreen) {
                $ignoreValidation = true;
                $statusUniqueName = new UniqueBookCodeAndName(BookEnums::PARAM_RULE_NAME);
                $statusUniqueBookCd = new UniqueBookCodeAndName(BookEnums::PARAM_RULE_BOOK_CD);
            }
        } else {
            $ignoreValidation = true;
        }

        $rules = [
            'book_cd' => [
                'required',
                'max:20',
                'regex:/^DX.*/',
                $statusUniqueBookCd,
            ],
            'name' => [
                'required',
                'max:50',
                $statusUniqueName,
            ],
            'author' => 'required|max:50',
            'categories' => ['required',new CheckCategoryActive()],
            'image' => $imageRule,
            'description' => 'required|max:255',
        ];

        if ($ignoreValidation) {
            $rules['quantity'] = 'required|max:20|integer|min:1';
            $rules['user_id'] = ['required', new CheckUserActive()];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'max' => 'Vui lòng nhập ít hơn :max ký tự.',
            'regex' => 'Vui lòng nhập đúng định dạng "DX....".',
            'integer' => 'Vui lòng nhập kiểu số nguyên.',
            'book_cd.required' => 'Vui lòng nhập mã sách.',
            'name.required' => 'Vui lòng nhập tên sách.',
            'book_cd.unique' => 'Mã sách đã tồn tại trong hệ thống .',
            'name.unique' => 'Tên  sách đã tồn tại trong hệ thống .',
            'author.required' => 'Vui lòng nhập tên tác giả.',
            'quantity.required' => 'Vui lòng nhập số lượng sách.',
            'user_id.required' => 'Vui lòng  chọn người đóng góp.',
            'categories.required' => 'Vui lòng  chọn loại sách.',
            'description.required' => 'Vui lòng nhập mô tả sách.',
            'quantity.max' => 'Vui lòng nhập giá trị nhỏ hơn 20',
            'quantity.min' => 'Vui lòng nhập giá trị lớn hơn 1',
            'image.required' => 'Vui lòng chọn hình ảnh.',
            'image.image' => 'Vui lòng chọn một file ảnh',
            'image.max' => 'Kích thước ảnh ít hơn 1 MB',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên sách',
            'book_cd' => 'Mã sách',
            'user_id' => 'Người đóng góp',
            'categories' => 'Loại sách',
        ];
    }
}
