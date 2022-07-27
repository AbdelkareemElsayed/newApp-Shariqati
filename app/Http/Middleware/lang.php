<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\app;
class lang
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
        // if (session()->has('lang')) {
        //     app()->setLocale(session('lang'));
        // } else {
            app()->setLocale('ar');

            # Set Session ...
            session()->put('lang', 'ar');
        //}
        return $next($request);
    }
}
