<?php


namespace App\Modules\Customer\Auth\Http\Requests;


use App\Models\User;
use App\Modules\Customer\Exceptions\VerifyCustomerException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class VerifyCustomerRequest extends FormRequest
{
    /**
     * @return bool
     * @throws \Exception
     */
    public function authorize()
    {
        $user = auth()->user();
        if ($user->getRememberToken() !== null && $user->getRememberToken() != $this->request->get('hash')) {
            throw ValidationException::withMessages(['hash' => __('Verify hash is incorrect')]);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
