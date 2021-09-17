<?php

namespace App\Modules\Admin\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required',
            'email' => [
                'required',
                Rule::unique('admins','email')->ignore(auth()->id())
            ],
            'password'  => ['nullable','min:8','regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/'],
        ];
    }
}
