<?php


namespace App\Modules\Customer\Auth\Http\Requests;


use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdatesUserPasswordsRequest extends FormRequest
{
    use PasswordValidationRules;

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
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => __('Password'),
            'password_confirmation' => __('Password Confirmation'),
            'current_password' => __('Current Password')
        ];
    }
}
