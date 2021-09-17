<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;

class Language
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
        // Check if the first segment matches a language code
        if (!in_array($request->segment(1), config('language_manager.locales')) ) {
            // Store segments in array
            $segments = $request->segments();
            // Set the default language code as the first segment
            $segments = Arr::prepend($segments, config('app.locale'));
            // Redirect to the correct url
            return redirect()->to(implode('/', $segments));
        }

        return $next($request);
    }
}
