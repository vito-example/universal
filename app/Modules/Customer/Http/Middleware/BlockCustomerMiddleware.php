<?php

namespace App\Modules\Customer\Http\Middleware;

use App\Models\User;
use Closure;

class BlockCustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user() && auth()->user()->status == User::STATUS_DISABLE) {
            return redirect()->route('user.disable');
        }
        return $next($request);
    }
}
