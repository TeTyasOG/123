<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // Добавление новой программы
    public function addProgram(Request $request)
    {
        try {
            $userId = \Auth::id(); 
            if (!$userId) {
                return response()->json(['message' => 'Требуется авторизация.'], 401);
            }

            // Загружаем данные пользователя (пол, вес)
            $user = User::find($userId);

            $name      = $request->input('name');
            $exercises = $request->input('exercises'); 
            
            if (!$name || empty($exercises)) {
                return response()->json(['message' => 'Пожалуйста, заполните все поля.'], 400);
            }

            // Создаём новую программу
            $program = Program::create([
                'user_id' => $userId,
                'name'    => $name,
            ]);

            // Записываем упражнения (pivot в таблице program_exercises)
            foreach ($exercises as $item) {
                $exerciseId = $item['exerciseId'] ?? null;
                $sets       = $item['sets']       ?? 0;
                $weight     = $item['weight']     ?? 0;
                $reps       = $item['reps']       ?? 0;
                // Если в будущем придёт RPE - возьмём её из запроса:
                // $rpe = $item['rpe'] ?? 5; (Но пока нет, фиксируем = 5)

                $program->exercises()->attach($exerciseId, [
                    'sets'   => $sets,
                    'weight' => $weight,
                    'reps'   => $reps,
                ]);
            }

            // --------------------------------
            // Считаем общий опыт программы
            // --------------------------------
            $totalXP = 0;
            foreach ($exercises as $item) {
                $exerciseId = $item['exerciseId'] ?? null;
                if (!$exerciseId) {
                    continue;
                }

                $exercise = Exercise::find($exerciseId);

                $sets   = $item['sets']   ?? 0;
                $weight = $item['weight'] ?? 0;
                $reps   = $item['reps']   ?? 0;

                // Допустим, при создании программы RPE = 5 (или берём из $item, если есть).
                $rpe = 5;

                // Для каждого "сета" суммируем XP
                for ($i = 0; $i < $sets; $i++) {
                    $xpForSet = $this->calculateSetXP($weight, $reps, $rpe, $exercise, $user);
                    $totalXP += $xpForSet;
                }
            }

            // Обновляем поле experience у программы и сохраняем
            $program->experience = $totalXP;
            $program->save();



            return response()->json(['message' => 'Программа успешно сохранена.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка при добавлении программы.'], 500);
        }
    }


    // -----------------------------------------
    // Пример метода удаления программы
    // -----------------------------------------
    public function deleteProgram(Request $request)
    {
        try {
            $userId = session('userId');
            $programId = $request->input('programId');

            $program = Program::where('id', $programId)
                ->where('user_id', $userId)
                ->first();

            if (!$program) {
                return response()->json(['message' => 'Программа не найдена.'], 404);
            }

            $program->delete();

            return response()->json(['message' => 'Программа успешно удалена.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка при удалении программы.'], 500);
        }
    }

    // -----------------------------------------
    // Возвращаем список программ пользователя
    // -----------------------------------------
    public function listPrograms(Request $request)
    {
        try {
            $userId = \Auth::id();
            if (!$userId) {
                return response()->json(['message' => 'Требуется авторизация.'], 401);
            }

            $programs = Program::where('user_id', $userId)->get();

            return response()->json($programs, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка сервера при получении программ.'], 500);
        }
    }

    // -------------------------------------------------------------------------------------
    // НИЖЕ - вспомогательные функции, аналогичные тем, что вы применяете при записи тренировки
    // -------------------------------------------------------------------------------------

    /**
     * Расчёт XP для 1 сета (аналогично WorkoutController::calculateSetXP),
     * но теперь с фолбэками для minW / maxW.
     */
    private function calculateSetXP($weight, $reps, $rpe, Exercise $exercise, User $user)
    {
        $gender    = ($user->gender === 'female') ? 'female' : 'male';
        $avgWeight = ($gender === 'female') ? 60 : 70;
        $userWeight= $user->weight ?? $avgWeight;
        $factor    = $userWeight / $avgWeight;

        // Ставим 20/100 по умолчанию, если в БД вдруг не заполнены
        $minW = ($gender === 'male')
            ? ($exercise->min_weight_male ?? 20)
            : ($exercise->min_weight_female ?? 20);
        $maxW = ($gender === 'male')
            ? ($exercise->max_weight_male ?? 100)
            : ($exercise->max_weight_female ?? 100);

        $adjMin = $minW * $factor;
        $adjMax = $maxW * $factor;

        // Вычисляем "уровень" (от 1 до 10) — аналог getWeightLevel
        $weightLevel = $this->calculateWeightLevel($weight, $adjMin, $adjMax);

        // Базовый XP = (уровень) * (кол-во повторений)
        $baseXP = $weightLevel * $reps;

        // RPE-бонус
        $rpeBonus = 0;
        if ($rpe > 5) {
            $rpeBonus = $baseXP * (($rpe - 5) * 0.05);
        }

        // Снижаем XP, если много повторений
        $multiRepFactor = 1.0;
        if ($reps >= 13 && $reps <= 15) {
            $multiRepFactor = 0.8;
        } elseif ($reps >= 16) {
            $multiRepFactor = 0.5;
        }

        $setXP = round(($baseXP + $rpeBonus) * $multiRepFactor);

        return $setXP;
    }

    /**
     * Уровень нагрузки (1..10).
     */
    private function calculateWeightLevel($weight, $minWeight, $maxWeight)
    {
        if ($weight <= $minWeight) {
            return 1;
        }
        if ($weight >= $maxWeight) {
            return 10;
        }
        $ratio = ($weight - $minWeight) / ($maxWeight - $minWeight);
        return round($ratio * 9 + 1);
    }
}
