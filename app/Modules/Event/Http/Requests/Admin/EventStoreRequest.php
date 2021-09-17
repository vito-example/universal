<?php

namespace App\Modules\Event\Http\Requests\Admin;

use App\Modules\Event\Http\Resources\Event\EventTypeOptions;
use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
        return [
            'main.' . config('language_manager.default_locale') . '.title' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
//            'event_sessions.sessions.fields.required' => 'Please insert session data',
        ];
    }
}
