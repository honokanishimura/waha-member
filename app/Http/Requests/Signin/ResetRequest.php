<?php

namespace App\Http\Requests\Signin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AdminPassword;

class ResetRequest extends FormRequest
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
            'password'              => ['bail', 'required', 'min:8', new AdminPassword, 'confirmed'],
            'password_confirmation' => ['bail', 'required', 'min:8', new AdminPassword,],
        ];
    }
}
