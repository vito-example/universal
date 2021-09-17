<?php

namespace App\Modules\Customer\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyStoreRequest extends FormRequest
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
            'title' => 'required',
            'identify_id' => 'required',
            'address' => 'required',
            'description' => 'required',

        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'company.title.required'  =>  __('validation.register.company_title_required'),
            'company.address.required'  =>  __('validation.register.company_address_required'),
            'company.identify_id.required'  =>  __('validation.register.company_identify_id_required'),
            'company.description.required'  =>  __('validation.register.company_description_required'),
        ];
    }

}
