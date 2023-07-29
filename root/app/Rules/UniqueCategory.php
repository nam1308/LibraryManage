<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Category;
use App\Enums\CategoryEnums;

class UniqueCategory implements Rule
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

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->param == CategoryEnums::PARAM_RULE_ID) {
            $existingCategory = Category::where(['id' => $value])->first();
            if (empty($existingCategory)) return false;
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
        return ':attribute chưa có trong hệ thống.';
    }
}
