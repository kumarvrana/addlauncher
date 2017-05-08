<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SiteUserMiddleware
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
         if(Sentinel::check() && Sentinel::getUser()->roles()->first()->slug == 'site-user'){
             return $next($request);
         }else
            return redirect()->route('user.signin');
    }
}
