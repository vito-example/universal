<?php
/**
 *  app\Modules\Customer\Http\Requests\Admin\LecturerStoreRequest.php
 *
 * Date-Time: 7/10/2021
 * Time: 1:56 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Customer\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LecturerStoreRequest
 * @package App\Modules\Customer\Http\Requests\Admin
 */
class LecturerStoreRequest extends FormRequest
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
            'main.' . config('language_manager.default_locale') . '.full_name'    => 'required',
            'main.' . config('language_manager.default_locale') . '.description'    => 'required',
            'main.directions' => 'nullable|array',
            'main.directions.*' => 'exists:directions,id',
        ];
    }
}
