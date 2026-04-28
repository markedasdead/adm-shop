<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $authenticatedUser = auth()->user();

        if(!$authenticatedUser) return back();

        return $next($request);
    }
}
