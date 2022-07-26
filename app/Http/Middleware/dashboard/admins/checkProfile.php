<?php

namespace App\Http\Middleware\dashboard\admins;

use Closure;
use Illuminate\Http\Request;

class checkProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       
   
        if($request->id == auth('admin')->user()->id && $request->role_id == auth('admin')->user()->role_id )
       {
        return $next($request);
       }else{
        
        return redirect()->back();
       }
       

    }
}
