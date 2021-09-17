<?php

namespace App\Modules\Company\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'main.title'    => 'required',
            'main.identify_id'    => 'required',
            'main.address'    => 'required'
        ];
    }
}
