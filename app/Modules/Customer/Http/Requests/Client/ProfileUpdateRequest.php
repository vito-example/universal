<?php

namespace App\Modules\Customer\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
        $user = auth()->user();
        return [
            'name' => ['required', 'string', 'max:200'],
            'surname' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email',Rule::unique('users','email')->ignore($user->id)],
            'phone_number' => ['required', 'digits:9', Rule::unique('users', 'phone_number')->ignore($user->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => __('validation.profile.name_regex'),
            'surname.regex' => __('validation.profile.surname_regex'),
            'name.required' => __('validation.profile.name_is_required'),
            'name.max' => __('validation.profile.name_max'),
            'surname.required' => __('validation.profile.surname_is_required'),
            'surname.max' => __('validation.profile.surname_max'),
            'phone_number.required' => __('validation.profile.phone_number_is_required'),
            'phone_number.digits' => __('validation.profile.phone_number_digits'),
            'phone_number.unique' => __('validation.profile.phone_number_unique'),
            'email.required' => __('validation.profile.email_required'),
            'email.unique' => __('validation.profile.email_unique'),
            'email.email' => __('validation.profile.email_type_email'),
        ];
    }

}
