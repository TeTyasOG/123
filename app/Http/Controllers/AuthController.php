<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|unique:users,nickname',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'gender' => 'required|string',
            'weight' => 'required|integer|min:1'
        ]);

        $hashedPassword = Hash::make($request->password);

        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => $hashedPassword,
            'gender' => $request->gender,
            'weight' => $request->weight,
        ]);

        $request->session()->put('userId', $user->_id);

        return response()->json(['message' => 'Регистрация успешна!']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        $login = $request->login;
        $user = User::where('email', $login)->orWhere('nickname', $login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Неверный логин или пароль.'], 400);
        }

        $request->session()->put('userId', $user->_id);

        return response()->json(['message' => 'Вход выполнен успешно!']);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();

        return response()->json(['message' => 'Вы успешно вышли из системы.']);
    }
}
