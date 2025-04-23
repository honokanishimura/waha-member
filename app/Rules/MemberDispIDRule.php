<?php

namespace App\Rules;

use App\Models\Member;
use Illuminate\Contracts\Validation\Rule;

class MemberDispIDRule implements Rule
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
        return preg_match('/^[a-zA-Z][0-9]{6}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->custom_message === null) {
            return trans('validation.member_regist_disp_id_rule');
        }
        else {
            return $this->custom_message;
        }
    }
}
