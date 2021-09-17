<?php


namespace App\Modules\Customer\Auth\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Customer\Auth\Http\Requests\PasswordResetLinkRequest;
use App\Modules\Customer\Auth\Notifications\ResetPasswordNotification;
use Closure;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;
use UnexpectedValueException;
use SeoData;
use View;

class PasswordResetLinkController extends Controller
{

    /**
     * Show the reset password link request view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse
     */
    public function create(Request $request): RequestPasswordResetLinkViewResponse
    {
        $allSeoData = SeoData::setTitle(__('seo.password-reset.title'))
            ->setDescription(__('seo.password-reset.description'))
            ->setKeywords(__('seo.password-reset.description'))
            ->setOgTitle(__('seo.password-reset.title'))
            ->setOgDescription(__('seo.password-reset.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return app(RequestPasswordResetLinkViewResponse::class);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PasswordResetLinkRequest $request
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(PasswordResetLinkRequest $request): Responsable
    {
        $user = User::where('phone_number', $request->phone_number)->firstOrFail();

        $status = $this->sendResetLink(
            ['email' => $user->email]
        );

        return $status == Password::RESET_LINK_SENT
            ? app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status])
            : app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
    }

    /**
     * @param array $credentials
     *
     * @return string
     */
    public function sendResetLink(array $credentials)
    {
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return PasswordBroker::INVALID_USER;
        }

        $token = $this->getUserResetPasswordToken();
        $user->forceFill([
            'remember_token' => $token
        ])->save();
        $user->notify(new ResetPasswordNotification($token));

        return PasswordBroker::RESET_LINK_SENT;
    }

    /**
     * @param array $credentials
     *
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getUser(array $credentials = [])
    {
        return User::where('email', $credentials['email'])->first();
    }

    /**
     * @return int
     */
    private function getUserResetPasswordToken()
    {
        return mt_rand(1000, 9999);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(): \Illuminate\Contracts\Auth\PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }

}
