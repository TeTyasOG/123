<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Предполагается, что у вас уже есть модель User
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Получение данных профиля пользователя
    public function getUserProfile()
    {
        try {
            $userId = Auth::id(); // Получаем ID текущего пользователя
            $user = User::find($userId);

            if ($user) {
                // Преобразуем сложные данные
                $exerciseExperience = is_array($user->exercise_experience) ? $user->exercise_experience : json_decode($user->exercise_experience, true) ?? [];
                $exerciseLevels = is_array($user->exercise_levels) ? $user->exercise_levels : json_decode($user->exercise_levels, true) ?? [];
                $muscleExperience = is_array($user->muscle_experience) ? $user->muscle_experience : json_decode($user->muscle_experience, true) ?? [];
                $muscleLevels = is_array($user->muscle_levels) ? $user->muscle_levels : json_decode($user->muscle_levels, true) ?? [];

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

            return response()->json(['message' => 'Пользователь не найден.'], 404);
        } catch (\Exception $e) {
            \Log::error('Ошибка при получении данных профиля пользователя: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при получении данных профиля пользователя.'], 500);
        }
    }

    // Обновление данных профиля пользователя
    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'nickname' => 'required|string|max:255',
                'gender' => 'required|string|max:10',
                'weight' => 'required|numeric|min:0.1',
            ]);

            $userId = Auth::id();
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['message' => 'Пользователь не найден.'], 404);
            }

            // Проверка уникальности никнейма
            $existingUser = User::where('nickname', $request->nickname)
                ->where('id', '!=', $userId)
                ->first();

            if ($existingUser) {
                return response()->json(['message' => 'Пользователь с таким никнеймом уже существует.'], 400);
            }

            $user->nickname = $request->nickname;
            $user->gender = $request->gender;
            $user->weight = $request->weight;
            $user->save();

            return response()->json(['message' => 'Профиль успешно обновлён.']);
        } catch (\Exception $e) {
            \Log::error('Ошибка при обновлении профиля: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при обновлении профиля.'], 500);
        }
    }
}
