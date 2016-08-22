<?php

namespace CodeDelivery\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
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
        if (!Auth::check()):
            return redirect('/auth/login');
        endif;
        
        if (Auth::user()->role <> 'admin'):
            return redirect('/auth/login');
        endif;
        
        return $next($request);
    }
}
