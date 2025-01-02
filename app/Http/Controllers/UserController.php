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
        \Log::info('Запрос профиля пользователя'); // Логируем вход в метод
        try {
            $userId = Auth::id(); 
            \Log::debug("User ID: $userId - запрошен профиль");
            
            $user = User::with(['muscles', 'exercises', 'achievements'])->find($userId);

            if (!$user) {
                \Log::warning("User ID: $userId не найден в БД");
                return response()->json(['message' => 'Пользователь не найден.'], 404);
            }

            // 1) Расчёт уровня игрока и его прогресса
            $userLevelData = $this->calculateUserLevelData($user->experience);

            // 2) Расчёт уровня каждой мышцы и её прогресса
            $muscleDataCollection = $user->muscles->map(function ($muscle) {
                $exp = $muscle->pivot->experience;  // <-- сырой опыт мышцы из связки
                $data = $this->calculateMuscleLevelData($exp);
            
                return [
                    'name'     => $muscle->name,
                    'level'    => $data['level'],
                    'startXP'  => $data['startXP'],
                    'nextXP'   => $data['nextXP'],
                    'muscleExp'=> $exp, // <-- ВАЖНО! Передаем сырой опыт
                ];
            });
            

            \Log::debug("User ID: $userId - уровень игрока: {$userLevelData['level']}");

            return response()->json([
                'nickname' => $user->nickname,
                'gender'   => $user->gender,
                'weight'   => $user->weight,

                // Опыт и уровень игрока
                'experience'=> $user->experience,
                'level'     => $userLevelData['level'],
                'startXP'   => $userLevelData['startXP'],
                'nextXP'    => $userLevelData['nextXP'],

                // Достижения
                'achievements' => $user->achievements->map(function ($achievement) {
                    return [
                        'name'        => $achievement->name,
                        'description' => $achievement->description,
                    ];
                }),

                // Информация по мышцам (только 6)
                // Теперь вместо сырых цифр экспы отдаём уровень и диапазоны
                'muscleExperience' => $muscleDataCollection,

                // Опыт по упражнениям (если нужно)
                'exerciseExperience' => $user->exercises->map(function ($exercise) {
                    return [
                        'name'       => $exercise->name,
                        'experience' => $exercise->pivot->experience,
                    ];
                }),
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
        \Log::info('Запрос обновления профиля пользователя'); // Логируем вход в метод
        try {
            $request->validate([
                'nickname' => 'required|string|max:255',
                'gender'   => 'required|string|in:male,female',
                'weight'   => 'required|numeric|min:0.1',
            ]);
    
            $userId = Auth::id();
            $user = User::find($userId);
    
            if (!$user) {
                \Log::warning("User ID: $userId не найден в БД при обновлении профиля");
                return response()->json(['message' => 'Пользователь не найден.'], 404);
            }
    
            // Проверка уникальности никнейма
            $existingUser = User::where('nickname', $request->nickname)
                                ->where('id', '!=', $userId)
                                ->first();
            if ($existingUser) {
                \Log::warning("User ID: $userId - никнейм {$request->nickname} уже используется");
                return response()->json(['message' => 'Пользователь с таким никнеймом уже существует.'], 400);
            }
    
            $user->nickname = $request->nickname;
            $user->gender   = $request->gender;
            $user->weight   = $request->weight;
            $user->save();
    
            \Log::debug("User ID: $userId - профиль успешно обновлён");
            return response()->json(['message' => 'Профиль успешно обновлён.']);
        } catch (\Exception $e) {
            \Log::error('Ошибка при обновлении профиля: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при обновлении профиля.'], 500);
        }
    }

    /**
     * Формула расчёта уровня для игрока по общему опыту (experience).
     * Используем заданные условия:
     *  Level <= 20 => XP = 200 * Level + 300
     *  21 <= Level <= 70 => XP = 12 * (Level^(1.5))
     *  Level > 70 => XP = 30000 * (1.08^(Level-70))
     *
     * Возвращаем массив:
     * [
     *   'level'   => (int),
     *   'startXP' => (float),
     *   'nextXP'  => (float)
     * ]
     */
    private function calculateUserLevelData(float $experience): array
    {
        // Ищем итеративно уровень, при котором опыт игрока не дотягивает
        // до "порога" следующего уровня.
        $level = 1;
        while ($level < 9999) {
            $currentXP = $this->getUserXPForLevel($level);
            $nextXP    = $this->getUserXPForLevel($level + 1);
            if ($experience < $nextXP) {
                // Возвращаем уровень, а также значения "старта" и "конца" уровня
                return [
                    'level'   => $level,
                    'startXP' => $currentXP,
                    'nextXP'  => $nextXP,
                ];
            }
            $level++;
        }

        // Если вдруг опыт очень большой (неформально ограничимся)
        return [
            'level'   => 9999,
            'startXP' => $this->getUserXPForLevel(9999),
            'nextXP'  => $this->getUserXPForLevel(9999) + 9999999
        ];
    }

    /**
     * Подсчёт Xp для заданного уровня игрока по формуле:
     *   if L <= 20: XP = 200 * L + 300
     *   if 21 <= L <= 70: XP = 12 * (L^(1.5))
     *   if L > 70: XP = 30000 * (1.08^(L - 70))
     */
    private function getUserXPForLevel(int $level): float
    {
        if ($level <= 20) {
            return 200 * $level + 300;
        } elseif ($level <= 70) {
            return 12 * pow($level, 1.5);
        } else {
            return 30000 * pow(1.08, ($level - 70));
        }
    }

    /**
     * Формула расчёта уровня мышцы по опыту: 
     *   XP = 50 * (Level^2) + 500
     *
     * Возвращаем массив:
     * [
     *   'level'   => (int),
     *   'startXP' => (float),
     *   'nextXP'  => (float)
     * ]
     */
    private function calculateMuscleLevelData(float $experience): array
    {
        // Аналогично, идём итеративно, пока не найдём уровень,
        // при котором опыт не дотягивает до "порога" следующего уровня.
        $level = 1;
        while ($level < 9999) {
            $currentXP = $this->getMuscleXPForLevel($level);
            $nextXP    = $this->getMuscleXPForLevel($level + 1);
            if ($experience < $nextXP) {
                return [
                    'level'   => $level,
                    'startXP' => $currentXP,
                    'nextXP'  => $nextXP,
                ];
            }
            $level++;
        }

        return [
            'level'   => 9999,
            'startXP' => $this->getMuscleXPForLevel(9999),
            'nextXP'  => $this->getMuscleXPForLevel(9999) + 9999999
        ];
    }

    /**
     * Подсчёт Xp для заданного уровня мышцы по формуле:
     *   XP = 50 * (Level^2) + 500
     */
    private function getMuscleXPForLevel(int $level): float
    {
        return 50 * ($level * $level) + 500;
    }
}
