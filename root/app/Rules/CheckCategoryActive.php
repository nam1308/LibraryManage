<?php

namespace App\Rules;

use App\Enums\CategoryEnums;
use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class CheckCategoryActive implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $categories = request('categories');
        $categoryIds = Category::whereIn('id', $categories)->where('status', CategoryEnums::STATUS_ACTIVE)->pluck('id')->toArray();

        if (count($categories) == count($categoryIds)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute không hợp lệ.';
    }
}
