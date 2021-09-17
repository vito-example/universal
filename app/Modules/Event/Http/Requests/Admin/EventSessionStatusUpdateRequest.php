<?php
/**
 *  app\Modules\Event\Http\Requests\Admin\EventSessionStatusUpdateRequest.php
 *
 * Date-Time: 7/25/2021
 * Time: 1:39 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Event\Http\Requests\Admin;

use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class EventSessionStatusUpdateRequest
 * @package App\Modules\Event\Http\Requests\Admin
 */
class EventSessionStatusUpdateRequest extends FormRequest
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
                Rule::in(EventSessionStatusOptions::getStatuses()->toArray())
            ]
        ];
    }
}
