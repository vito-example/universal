<?php


namespace App\Modules\Customer\Auth\Http\Controllers;


use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Actions\CompletePasswordReset;
use Laravel\Fortify\Contracts\FailedPasswordResetResponse;
use Laravel\Fortify\Contracts\PasswordResetResponse;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Fortify;

class NewPasswordController extends \Laravel\Fortify\Http\Controllers\NewPasswordController
{

    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(Request $request): Responsable
    {
        $request->validate([
            'token' => 'required',
            'phone_number' => 'required',
        ]);
        try {
            $user = User::where('phone_number',$request->get('phone_number'))
                ->where('remember_token',$request->get('token'))->firstOrFail();

            app(ResetsUserPasswords::class)->reset($user, $request->all());
            $user->forceFill([
                'remember_token' => null
            ])->save();
            return app(PasswordResetResponse::class, ['status' => Password::PASSWORD_RESET]);
        } catch (\Exception $ex) {
            return app(FailedPasswordResetResponse::class, ['status' => Password::INVALID_USER]);
        }
    }

}
