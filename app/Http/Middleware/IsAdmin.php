<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login as Admin to continue.');
        }

        if (! auth()->user()->isAdmin()) {
            return redirect()->route('home')
                ->with('error', 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
