<?php

namespace App\Modules\Event\Http\Requests\Admin;

use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventStatusUpdateRequest extends FormRequest
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
            'status'    => [
                'required',
                Rule::in(EventStatusOptions::getStatuses()->toArray())
            ]
        ];
    }
}
