<?php
/**
 *  app\Modules\Pages\Http\Requests\Admin\Service\ServiceStoreRequest.php
 *
 * Date-Time: 9/21/2021
 * Time: 5:29 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Http\Requests\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            'main.' . config('language_manager.default_locale') . '.title'    => 'required'
        ];
    }
}
