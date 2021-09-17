<?php
/**
 *  app\Modules\Event\Http\Requests\Client\Event\RequestEvent.php
 *
 * Date-Time: 8/17/2021
 * Time: 9:13 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Event\Http\Requests\Client\Event;

use Illuminate\Foundation\Http\FormRequest;

class RequestEvent extends FormRequest
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
            'max_person' => 'nullable|numeric|min:1',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'max_person.min' => __('validation.register.max_person.min'),
            'max_person.numeric' => __('validation.register.max_person.numeric'),
        ];
    }
}
