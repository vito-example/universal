<?php
/**
 *  app\Modules\Customer\Auth\Http\Requests\FinishProfileRequest.php
 *
 * Date-Time: 9/16/2021
 * Time: 5:25 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Auth\Http\Requests;


use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FinishProfileRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'phone_number' => ['required','numeric','unique:users,phone_number', 'digits:9'],
            'email' => [
                'required',
                'email',
                Rule::unique('admins','email')->ignore(auth()->id())
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'phone_number.required' => __('validation.register.phone_number_required'),
            'phone_number.digits' => __('validation.register.phone_number_digits'),
            'phone_number.unique' => __('validation.register.phone_number_unique'),
            'phone_number.numeric' => __('validation.register.phone_number_numeric'),
            'email.required' => __('validation.register.email_required'),
            'email.unique' => __('validation.register.email_unique'),
            'email.email' => __('validation.register.email_type_email'),
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'password'  => __('Register Password')
        ];
    }

}
