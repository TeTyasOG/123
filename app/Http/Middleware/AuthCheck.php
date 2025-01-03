<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        // Проверяем авторизацию
        if (!Auth::check()) {
            // Если не авторизован, редиректим на /login
            // Или route('login'), если он назван 'login'
            return redirect()->route('login');
        }

        return $next($request);
    }
}

