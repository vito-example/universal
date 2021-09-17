<?php


namespace App\Http\Middleware;


use App\Models\User;
use App\Modules\Customer\Auth\Interfaces\MustVerifyPhone;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureUserIsDisabled
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
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyPhone &&
                $request->user()->status == User::STATUS_DISABLE)) {
            //TODO
        }

        return $next($request);
    }
}
