<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\RedirectResponse;

class Authenticate extends Middleware
{
    protected function redirectTo($request): string
    {
        if (! $request->expectsJson()) {
            return route('auth.login');
        }
    }
}
