<?php
/**
 *  app\Modules\Pages\Http\Requests\Admin\Team\TeamStoreRequest.php
 *
 * Date-Time: 9/19/2021
 * Time: 5:03 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Pages\Http\Requests\Admin\Team;

use Illuminate\Foundation\Http\FormRequest;

class TeamStoreRequest extends FormRequest
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
            'main.' . config('language_manager.default_locale') . '.name'    => 'required'
        ];
    }
}
