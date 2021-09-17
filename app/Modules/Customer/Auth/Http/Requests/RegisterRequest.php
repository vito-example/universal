<?php


namespace App\Modules\Customer\Auth\Http\Requests;


use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $validateData = [
            'name' => ['required', 'string', 'max:200'],
            'surname' => ['required', 'string','max:200'],
            'phone_number' => ['required','numeric','unique:users,phone_number', 'digits:9'],
            'email' => ['required', 'email','unique:users,email'],
            'password' => $this->passwordRules(),
            'terms' => ['required', 'accepted'],
        ];

        if (!empty(request()->get('legal_person'))) {
            $validateData['company'] = ['required','array'];
            $validateData['company.*.title'] = ['required'];
            $validateData['company.*.address'] = ['required'];
            $validateData['company.*.identify_id'] = ['required'];
            $validateData['company.*.description'] = ['required'];
            $validateData['company_employee'] = ['nullable','array'];
            $validateData['company_employee.*.name'] = ['required'];
            $validateData['company_employee.*.email'] = ['required','email'];
        }

        return $validateData;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('validation.register.name_required'),
            'name.max' => __('validation.register.name_max'),
            'name.regex' => __('validation.register.name_regex'),
            'surname.regex' => __('validation.register.surname_regex'),
            'surname.required' => __('validation.register.surname_required'),
            'surname.max' => __('validation.register.surname_max'),
            'phone_number.required' => __('validation.register.phone_number_required'),
            'phone_number.digits' => __('validation.register.phone_number_digits'),
            'phone_number.unique' => __('validation.register.phone_number_unique'),
            'phone_number.numeric' => __('validation.register.phone_number_numeric'),
            'terms.required' => __('validation.register.terms_required'),
            'terms.accepted' => __('validation.register.terms_accepted'),
            'email.required' => __('validation.register.email_required'),
            'email.unique' => __('validation.register.email_unique'),
            'email.email' => __('validation.register.email_type_email'),
            'password.required'  =>  __('validation.register.password_required'),
            'password.confirmed'  =>  __('validation.register.password_confirmed'),
            'company.required'  =>  __('validation.register.company_required'),
            'company.array'  =>  __('validation.register.company_array'),
            'company.*.title.required'  =>  __('validation.register.company_title_required'),
            'company.*.address.required'  =>  __('validation.register.company_address_required'),
            'company.*.identify_id.required'  =>  __('validation.register.company_identify_id_required'),
            'company.*.description.required'  =>  __('validation.register.company_description_required'),
            'company_employee.array'  =>  __('validation.register.company_employee_array'),
            'company_employee.*.name.required'  =>  __('validation.register.company_employee_name_required'),
            'company_employee.*.email.required'  =>  __('validation.register.company_employee_email_required'),
            'company_employee.*.email.email'  =>  __('validation.register.company_employee_email_email'),

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
