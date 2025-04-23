<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MemberPassword implements Rule
{
    private $custom_message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($custom_message = null)
    {
        $this->custom_message = $custom_message;
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
        if ($this->custom_message === null) {
            return trans('validation.member_password');
        }
        else {
            return $this->custom_message;
        }
    }
}
