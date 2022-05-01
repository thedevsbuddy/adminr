<?php

namespace App\Http\Middleware;

use App\Traits\HasResponse;
use Closure;
use Illuminate\Http\Request;

class VerifiedUser
{
    use HasResponse;

    public function handle(Request $request, Closure $next)
    {
        if(auth()->check()){
            if (is_null(auth()->user()->email_verified_at)){
                return $this->redirectError(route: route('auth.verify'), message: "Email is not verified!");
            }
        }
        return $next($request);
    }
}
