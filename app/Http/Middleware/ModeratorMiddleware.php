<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModeratorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'moderator'])) {
            return redirect()->route('home')->with('error', 'У вас нет прав для доступа к этой странице.');
        }

        return $next($request);
    }
} 