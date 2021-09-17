<?php
/**
 *  app/Modules/Event/Http/Requests/Admin/EventSessionRequestStoreRequest.php
 *
 * Date-Time: 28.07.21
 * Time: 14:36
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
namespace App\Modules\Event\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EventSessionRequestStoreRequest
 * @package App\Modules\Event\Http\Requests\Admin
 */
class EventSessionRequestStoreRequest extends FormRequest
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
            'event_id' => 'required',
            'max_person' => 'required',
            'start_date' => 'required|before:end_date',
            'end_date' => 'required',
            'timezone' => 'required',
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
            'start_date.before' => 'Start Date can not be more than End Date',
        ];
    }
}
