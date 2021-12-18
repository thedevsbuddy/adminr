<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->hasAnyRole(['admin', 'super_admin'])){
            return redirect(url('/'))->with('error', 'You don\'t have permission to access admin routes!s');
        }
        return $next($request);
    }
}
