<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Book;
use App\Enums\BookEnums;

class UniqueBookCodeAndName implements Rule
{
    protected $param;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    public function passes($attribute, $value)
    {
        $bookCd = request('book_cd');
        $name = request('name');
        $existingBook = Book::where(['book_cd' => $bookCd, 'name' => $name])
            ->first();
        if ($existingBook) {
            return true;
        }
        if ($this->param == BookEnums::PARAM_RULE_BOOK_CD) {
            $bookWithCode = Book::where('book_cd', $bookCd)->first();
            if ($bookWithCode) {
                return false;
            }
        }

        if ($this->param == BookEnums::PARAM_RULE_NAME) {
            $bookWithName = Book::where('name', $name)->whereNull('deleted_at')->first();
            if ($bookWithName) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  ':attribute đã có trong hệ thống .';
    }
}
