<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultRestApiHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request)
            ->header('Content-Type', 'application/json')
            ->header('Connection', 'keep-alive')
            ->header('Keep-Alive', 'timeout=60');
    }
}
