<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AdminPassword implements Rule
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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $score = 0;

        if (preg_match('/[a-zA-Z]/', $value)) $score++;
        if (preg_match('/[0-9]/', $value)) $score++;

        if ($score >= 2) {
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
        return trans('validation.admin_password');
    }
}
