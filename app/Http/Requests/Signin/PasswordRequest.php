<?php

namespace App\Http\Requests\Signin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MemberPasswordResetEmail;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email:rfc'],
        ];
    }
}
