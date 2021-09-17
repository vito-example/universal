<?php
/**
 *  app/Modules/Customer/Http/Requests/Client/CompanyEmployeeStoreRequest.php
 *
 * Date-Time: 26.08.21
 * Time: 08:59
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Customer\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyEmployeeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'name' => 'required',
            'email' => 'required|email',

        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'  =>  __('validation.register.company_employee_name_required'),
            'email.required'  =>  __('validation.register.company_employee_email_required'),
            'email.email'  =>  __('validation.register.company_employee_email_email'),
        ];
    }

}
