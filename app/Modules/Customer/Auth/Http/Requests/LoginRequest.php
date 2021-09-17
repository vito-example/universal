<?php


namespace App\Modules\Customer\Auth\Http\Requests;


use Laravel\Fortify\Fortify;

class LoginRequest extends \Laravel\Fortify\Http\Requests\LoginRequest
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
            Fortify::username() => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => __('validation.login.password_is_required'),
            Fortify::username() .'.required' => __('validation.login.username_is_required')
        ];
    }

}
