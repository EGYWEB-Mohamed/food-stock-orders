<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIfIsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() and ! auth()->user()->isAdmin()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
