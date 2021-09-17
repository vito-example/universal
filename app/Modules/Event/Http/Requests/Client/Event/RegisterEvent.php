<?php
/**
 *  app\Modules\Event\Http\Requests\Client\Event\RegisterEvent.php
 *
 * Date-Time: 8/15/2021
 * Time: 12:40 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Event\Http\Requests\Client\Event;

use Illuminate\Foundation\Http\FormRequest;

class RegisterEvent extends FormRequest
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
    public function rules(): array
    {
        $validateData = [
            'mode' => 'required',
            'session_id' => 'required',
        ];

        if ($this->mode === 'company') {
            if (null === $this->company_id) {
                $validateData['company.title'] = ['required'];
                $validateData['company.identify_id'] = ['required'];
                $validateData['company.address'] = ['required'];
                $validateData['company.description'] = ['required'];
            }

            if (count($this->company_employee) === 1) {
                if (($this->company_employee[0]['name'] != '' ||
                    $this->company_employee[0]['email'] != '' ||
                    $this->company_employee[0]['phone'] != '' ||
                    $this->company_employee[0]['role'] != '') ||
                    null === $this->company_id ||
                    !count($this->employees)
                ) {
                    $validateData['company_employee.*.name'] = ['required'];
                    $validateData['company_employee.*.email'] = ['required','email'];
                }
            } else {
                $validateData['company_employee.*.name'] = ['required'];
                $validateData['company_employee.*.email'] = ['required','email'];
            }

        }

        return $validateData;
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'company.mode.required' => __('validation.register.mode_required'),
            'company.title.required' => __('validation.register.company_title_required'),
            'company.description.required' => __('validation.register.company_description_required'),
            'company_employee.*.name.required'  =>  __('validation.register.company_employee_name_required'),
            'company_employee.*.email.required'  =>  __('validation.register.company_employee_email_required'),
            'company_employee.*.email.email'  =>  __('validation.register.company_employee_email_email'),
            'terms.required' => __('validation.register.terms_required'),
        ];
    }
}
