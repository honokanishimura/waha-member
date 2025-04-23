<?php

namespace App\Rules;

use App\Models\Member;
use Illuminate\Contracts\Validation\Rule;

class MemberDispIDDuplicate implements Rule
{
    private $exclude_member_id;
    private $custom_message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($exclude_member_id = null, $custom_message = null)
    {
        $this->exclude_member_id = $exclude_member_id;
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
        return Member::isRegistableDispID($value, $this->exclude_member_id);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->custom_message === null) {
            return trans('validation.member_regist_disp_id_duplicate');
        }
        else {
            return $this->custom_message;
        }
    }
}
