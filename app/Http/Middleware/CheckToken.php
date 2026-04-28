<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\ResponseTrait;

class CheckToken
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if(!$bearerToken) return $this->errors(code: 403, message: "Forbidden for you");

        $authenticatedUser = User::where('token', $bearerToken)->first();

        if(!$authenticatedUser) return $this->errors(code: 403, message: "Forbidden for you");

        auth()->login($authenticatedUser);

        return $next($request);
    }
}
