<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * @param mixed $user
     * @param array $input
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reset($user, array $input)
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ],[
            'password.required'  =>  __('validation.register.password_required'),
            'password.confirmed'  =>  __('validation.register.password_confirmed'),
        ],[
            'password'  => __('Register Password')
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
