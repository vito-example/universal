<?php

namespace App\Modules\Event\Http\Requests\Client\Event;

use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventQuestion extends FormRequest
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
            'content'   => [
                'required'
            ]
        ];
    }
}
