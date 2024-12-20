<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Регистрация нового пользователя
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nickname' => 'required|string|max:255|unique:users,nickname',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|string|in:male,female,other',
            'weight' => 'required|numeric|min:1',
        ]);

        $user = User::create([
            'nickname' => $validatedData['nickname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'gender' => $validatedData['gender'],
            'weight' => $validatedData['weight'],
        ]);

        Auth::login($user);
        
        $request->session()->put('userId', $user->id);

        return response()->json(['message' => 'Регистрация успешна!'], 201);
    }

    // Вход пользователя
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['login'])
                    ->orWhere('nickname', $credentials['login'])
                    ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Неверный логин или пароль.'], 400);
        }

        Auth::login($user);

        return response()->json([
            'message' => 'Вход выполнен успешно!',
            'user' => $user
        ]);
    }

    // Выход из системы
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Вы успешно вышли из системы.']);
    }
    
}
