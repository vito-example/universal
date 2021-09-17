<?php

namespace App\Modules\Base\Http\Requests\Admin\Slug;

use Illuminate\Foundation\Http\FormRequest;

class SlugStoreRequest extends FormRequest
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
            'main.url'           => 'required',
            'main.redirect_url'  => 'required_without:main.slugable'
        ];
    }
}
