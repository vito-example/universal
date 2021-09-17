<?php

namespace App\Modules\Pages\Http\Requests\Admin\StaticPage;

use Illuminate\Foundation\Http\FormRequest;

class StaticPageStoreRequest extends FormRequest
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
            'main.'.config('language_manager.default_locale').'.title'     => 'required'
        ];
    }
}
