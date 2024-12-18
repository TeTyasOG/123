<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('userId')) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        return $next($request);
    }
}
