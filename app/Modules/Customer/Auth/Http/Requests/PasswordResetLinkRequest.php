<?php


namespace App\Modules\Customer\Auth\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Fortify;

class PasswordResetLinkRequest extends FormRequest
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
            'phone_number' => 'required|exists:users,phone_number',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'phone_number.required' => __('validation.password_reset.phone_number_is_required'),
            'phone_number.exists' => __('validation.password_reset.phone_number_not_exists')
        ];
    }

}
