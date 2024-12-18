<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserProfile(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден.'], 404);
        }

        // В Node.js коде был Map, здесь у нас массивы
        $muscleExperience = $user->muscleExperience ?? [];
        $muscleLevels = $user->muscleLevels ?? [];
        $exerciseExperience = $user->exerciseExperience ?? [];
        $exerciseLevels = $user->exerciseLevels ?? [];

        return response()->json([
            'nickname' => $user->nickname,
            'gender' => $user->gender,
            'level' => $user->level,
            'experience' => $user->experience,
            'achievements' => $user->achievements ?? [],
            'muscleExperience' => $muscleExperience,
            'muscleLevels' => $muscleLevels,
            'exerciseExperience' => $exerciseExperience,
            'exerciseLevels' => $exerciseLevels,
            'weight' => $user->weight ?? null,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string',
            'gender' => 'required|string',
            'weight' => 'required|integer|min:1'
        ]);

        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        // Проверяем уникальность никнейма
        $existingUser = User::where('nickname', $request->nickname)->where('_id', '!=', $userId)->first();
        if ($existingUser) {
            return response()->json(['message' => 'Пользователь с таким никнеймом уже существует.'], 400);
        }

        User::where('_id', $userId)->update([
            'nickname' => $request->nickname,
            'gender' => $request->gender,
            'weight' => $request->weight
        ]);

        return response()->json(['message' => 'Профиль успешно обновлён.']);
    }
}
