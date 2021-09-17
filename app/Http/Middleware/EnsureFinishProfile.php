<?php
/**
 *  app\Http\Middleware\EnsureFinishProfile.php
 *
 * Date-Time: 9/16/2021
 * Time: 5:13 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureFinishProfile
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return RedirectResponse
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (!$request->user()) {
            return $next($request);
        }
        if (! $request->user() ||
            (!$request->user()->email ||
                ! $request->user()->phone_number)) {
            return $request->expectsJson()
                ? abort(403, 'Your profile is not finished.')
                : Redirect::guest(URL::route($redirectToRoute ?: 'profile.finish'));
        }

        return $next($request);
    }
}
