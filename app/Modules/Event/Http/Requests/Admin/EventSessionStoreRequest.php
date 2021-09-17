<?php
/**
 *  app/Modules/Event/Http/Requests/Admin/EventSessionStoreRequest.php
 *
 * Date-Time: 26.07.21
 * Time: 11:46
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
namespace App\Modules\Event\Http\Requests\Admin;

use App\Modules\Event\Http\Resources\Event\EventTypeOptions;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EventSessionStoreRequest
 * @package App\Modules\Event\Http\Requests\Admin
 */
class EventSessionStoreRequest extends FormRequest
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
            'main.event_id' => 'required',
            'main.max_person' => 'required',
            'main.start_date' => 'required|before:main.end_date',
            'main.end_date' => 'required',
            'main.timezone' => 'required',
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
            'main.start_date.before' => 'Start Date can not be more than End Date',
        ];
    }
}
