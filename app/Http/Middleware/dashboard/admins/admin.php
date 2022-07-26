<?php

namespace App\Http\Middleware\dashboard\admins;

use Closure;
use Illuminate\Support\Facades\Auth;
class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next = null, $guard = null)
    {
      if(auth('admin')->check()){
         return $next($request);
       }else{
        return redirect(aurl('login'));
            }

  }
}
