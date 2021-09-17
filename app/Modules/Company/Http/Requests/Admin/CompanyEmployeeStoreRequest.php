<?php
/**
 *  app/Modules/Company/Http/Requests/Admin/CompanyEmployeeStoreRequest.php
 *
 * Date-Time: 22.07.21
 * Time: 14:25
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Company\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class CompanyEmployeeStoreRequest
 * @package App\Modules\Company\Http\Requests\Admin
 */
class CompanyEmployeeStoreRequest extends FormRequest
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
            'main.name'    => 'required',
            'main.email'    => 'required|email'
        ];
    }
}