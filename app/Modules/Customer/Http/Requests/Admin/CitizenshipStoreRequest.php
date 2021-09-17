<?php

namespace App\Modules\Customer\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CitizenshipStoreRequest extends FormRequest
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
            'main.country_code'    => 'required',
            'main.' . config('language_manager.default_locale') . '.title'    => 'required'
        ];
    }
}
