<?php

namespace App\Http\Requests\Members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\MemberDispIDDuplicate;
use App\Rules\MemberDispIDRule;
use App\Rules\MemberPassword;
use App\Rules\MemberRegistEmail;

class CreateRequest extends FormRequest
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
            'disp_id'               => ['nullable', new MemberDispIDRule, new MemberDispIDDuplicate],
            'company'               => ['required'],
            'department'            => ['required'],
            'position'              => [],
            'lname'                 => ['required'],
            'fname'                 => ['required'],
            'email'                 => ['required', 'email:rfc', new MemberRegistEmail],
            'password'              => ['required', 'min:8', new MemberPassword, 'confirmed'],
            'password_confirmation' => [],
            'industry'              => ['nullable', Rule::in(array_keys(config('const.member.industry')))],
            'location'              => ['nullable', Rule::in(array_keys(config('const.member.location')))],
            'employee'              => ['nullable', Rule::in(array_keys(config('const.member.employee')))],
            'affiliation'           => ['nullable', Rule::in(array_keys(config('const.member.affiliation')))],
            'handling'              => ['nullable', 'array'],
            'handling.*'            => [Rule::in(array_keys(config('const.member.handling')))],
        ];
    }
}
