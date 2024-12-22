<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Получение данных профиля пользователя
     */
    public function getUserProfile()
    {
        try {
            $userId = Auth::id(); 
            $user = User::with(['muscles', 'exercises', 'achievements'])->find($userId);

            if (!$user) {
                return response()->json(['message' => 'Пользователь не найден.'], 404);
            }

            // Расчёт уровня на основе общего опыта (experience)
            // —— Начало перенесённой формулы ——
            // Стараемся не менять "баланс", но адаптируем под PHP
            $userLevelData = $this->calculateLevelData($user->experience);
            // —— Конец перенесённой формулы ——

            return response()->json([
                'nickname'  => $user->nickname,
                'gender'    => $user->gender,
                'experience'=> $user->experience,
                'level'     => $userLevelData['level'],
                'startXP'   => $userLevelData['startXP'],
                'nextXP'    => $userLevelData['nextXP'],
                
                'achievements' => $user->achievements->map(function ($achievement) {
                    return [
                        'name'        => $achievement->name,
                        'description' => $achievement->description,
                    ];
                }),

                // Опыт по мышцам (теперь только 6 мышц, по pivot->experience)
                'muscleExperience' => $user->muscles->map(function ($muscle) {
                    return [
                        'name'       => $muscle->name,
                        'experience' => $muscle->pivot->experience,
                    ];
                }),

                // Опыт по упражнениям
                'exerciseExperience' => $user->exercises->map(function ($exercise) {
                    return [
                        'name'       => $exercise->name,
                        'experience' => $exercise->pivot->experience,
                    ];
                }),

                'weight' => $user->weight,
            ]);

        } catch (\Exception $e) {
            \Log::error('Ошибка при получении данных профиля пользователя: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при получении данных профиля пользователя.'], 500);
        }
    }

    /**
     * Обновление данных профиля пользователя
     */
    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'nickname' => 'required|string|max:255',
                'gender'   => 'required|string|in:male,female',
                'weight'   => 'required|numeric|min:0.1',
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
            $user->gender   = $request->gender;
            $user->weight   = $request->weight;
            $user->save();
    
            return response()->json(['message' => 'Профиль успешно обновлён.']);
        } catch (\Exception $e) {
            \Log::error('Ошибка при обновлении профиля: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при обновлении профиля.'], 500);
        }
    }

    /**
     * Функция расчёта уровня по опыту — перенесённая формула
     *
     * Важно: сохраняем тот же "баланс" и "логику".
     *
     * Возвращаем:
     * [
     *   'level'   => (int),
     *   'startXP' => (float),
     *   'nextXP'  => (float)
     * ]
     */
    private function calculateLevelData(float $experience): array
    {
        // Пример реализации (тот же принцип, что был в JS):
        // if level <= 20 -> линейный рост (как было)
        // if level <= 70 -> (пример) с Math.pow(...)
        // else           -> ...
        // НО! тут придётся итеративно найти уровень, т.к. изначально формула
        // была написана как getExperienceRangeForLevel(level).
        // Или же используем тот самый кусок (startXP, nextXP) и ищем level по возрастанию.

        $level = 1;
        while (true) {
            $range = $this->getExperienceRangeForLevel($level);
            // если опыт не дотягивает до следующего диапазона — останавливаемся
            if ($experience < $range['nextXP']) {
                return [
                    'level'   => $level,
                    'startXP' => $range['startXP'],
                    'nextXP'  => $range['nextXP'],
                ];
            }
            $level++;
            // защита от бесконечных циклов — вдруг опыт слишком большой?
            if ($level > 9999) {
                // условно, ограничимся каким-то безумным уровнем
                return [
                    'level'   => 9999,
                    'startXP' => $range['startXP'],
                    'nextXP'  => $range['nextXP'] * 10, // просто чтоб не падать
                ];
            }
        }
    }

    /**
     * "Исходная" функция из JS (не меняем баланс) — даём её как private
     * Возвращает startXP и nextXP для указанного $level
     */
    private function getExperienceRangeForLevel(int $level): array
    {
        if ($level <= 20) {
            $startXP = 200 * ($level - 1) + 300;
            $nextXP  = 200 * $level + 300;
        } elseif ($level <= 70) {
            // Если level 21 -> startXP = 8600 + Math.pow(0, 1.5)*12 = 8600
            // Будем считать, что для целых чисел math.pow(...) корректно
            $startXP = 8600 + pow($level - 21, 1.5) * 12;
            $nextXP  = 8600 + pow($level - 20, 1.5) * 12;
        } else {
            $startXP = 1800000 + 30000 * pow(1.08, $level - 71);
            $nextXP  = 1800000 + 30000 * pow(1.08, $level - 70);
        }

        return [
            'startXP' => $startXP < 0 ? 0 : $startXP,
            'nextXP'  => $nextXP < 0 ? 0 : $nextXP,
        ];
    }
}
