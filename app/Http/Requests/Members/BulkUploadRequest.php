<?php

namespace App\Http\Requests\Members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\MemberDispIDDuplicate;
use App\Rules\MemberDispIDRule;
use App\Rules\MemberPassword;
use App\Rules\MemberRegistEmail;

class BulkUploadRequest extends FormRequest
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
            'bulk_upload_file'      => ['required', 'file'],
        ];
    }

}
