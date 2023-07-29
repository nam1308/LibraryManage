<?php

namespace App\Rules;

use App\Enums\UserEnums;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckUserActive implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $userId = request('user_id');
        $userExitsActive = User::where(['id' => $userId, 'status' => UserEnums::STATUS_ACTIVE])->first();

        if ($userExitsActive) {
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
