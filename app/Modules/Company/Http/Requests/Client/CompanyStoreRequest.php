<?php

namespace App\Modules\Company\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'photo' => ['required', 'image'],
            'title' => 'required',
            'identity_id'   => [
                'required',
                'numeric',
                Rule::unique('companies')->ignore(request()->get('id'))
            ],
            'activities' => 'required',
            'activities.*' => ['required','exists:activities,id']
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'photo.required' => __('validation.company.title_required'),
            'photo.image' => __('validation.company.title_image'),
            'title.required' => __('validation.company.title_is_required'),
            'identity_id.required' => __('validation.company.identity_id_is_required'),
            'identity_id.unique' => __('validation.company.identity_id_unique'),
            'identity_id.numeric' => __('validation.company.company_title_numeric'),
            'activities.required' => __('validation.company.activities_required'),
        ];
    }

}
