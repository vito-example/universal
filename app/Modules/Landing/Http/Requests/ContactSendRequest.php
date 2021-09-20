<?php
/**
 *  app/Modules/Landing/Http/Requests/ContactSendRequest.php
 *
 * Date-Time: 09.08.21
 * Time: 10:12
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Landing\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSendRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.contact.name_required'),
            'email.required' => __('validation.contact.email_required'),
            'email.email' => __('validation.contact.email_email'),
            'message.required' => __('validation.contact.message_required'),
        ];
    }
}
