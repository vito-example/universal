<?php

namespace App\Modules\Customer\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerStoreRequest extends FormRequest
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
            'main.name' => ['required', 'string', 'max:255'],
            'main.surname' => ['required', 'string', 'max:255'],
            'main.phone_number' => ['required', 'digits:9', Rule::unique('users', 'phone_number')->ignore(request()->get('id'))],
            'main.email' => ['required', 'email', Rule::unique('users', 'email')->ignore(request()->get('id'))]
        ];
    }
}
