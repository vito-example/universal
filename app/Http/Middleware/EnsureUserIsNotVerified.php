<?php


namespace App\Http\Middleware;


use App\Modules\Customer\Auth\Interfaces\MustVerifyPhone;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureUserIsNotVerified
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if ($request->user() &&
            ($request->user() instanceof MustVerifyPhone &&
                $request->user()->hasVerifiedPhone())) {
            return $request->expectsJson()
                ? abort(403, 'Your phone number is verified.')
                : redirect()->intended(config('fortify.home'));
        }

        return $next($request);
    }
}
