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
        'gender' => 'required|string|in:male,female',
        'weight' => 'required|numeric|min:1',
    ]);


    try {
        $user = User::create([
            'nickname' => $validatedData['nickname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'gender' => $validatedData['gender'],
            'weight' => $validatedData['weight'],
        ]);

        Auth::login($user);

        return redirect()->route('profile'); // Редирект на страницу профиля
    } catch (\Exception $e) {
    }
}


    // Вход пользователя
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Поиск пользователя по email или nickname
        $user = User::where('email', $credentials['login'])
                    ->orWhere('nickname', $credentials['login'])
                    ->first();

        // Проверка пароля
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Неверный логин или пароль.'], 400);
        }

        // Авторизация пользователя
        Auth::login($user);

        return redirect()->route('profile');// URL для редиректа
        ;
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
