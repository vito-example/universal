<?php
/**
 *  app/Modules/Customer/Http/Requests/Admin/DirectionStoreRequest.php
 *
 * Date-Time: 07.07.21
 * Time: 09:15
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
namespace App\Modules\Customer\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DirectionStoreRequest
 * @package App\Modules\Customer\Http\Requests\Admin
 */
class DirectionStoreRequest extends FormRequest
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
            'main.' . config('language_manager.default_locale') . '.title'    => 'required'
        ];
    }
}
