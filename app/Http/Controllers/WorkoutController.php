<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Muscle;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use App\Models\ExerciseSet;
use App\Models\Program;

class WorkoutController extends Controller
{
    /**
     * Получение списка упражнений (пример).
     */
    public function getExercises(Request $request)
    {
        try {
            $muscleGroup = $request->query('muscleGroup');
            $searchQuery = $request->query('searchQuery');

            $query = Exercise::query();

            // Если нужна фильтрация по muscleFilter
            if (!empty($muscleGroup) && $muscleGroup !== 'ВСЕ МЫШЦЫ') {
                // Пример (если у вас есть связь muscleFilters())
                // $query->whereHas('muscleFilters', function($q) use ($muscleGroup) {
                //     $q->where('name', $muscleGroup);
                // });
            }

            if (!empty($searchQuery)) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            }

            $exercises = $query->get();
            return response()->json($exercises);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении упражнений: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении упражнений.'], 500);
        }
    }

    /**
     * Получение последних упражнений.
     * Используем workout_exercises -> exercise_id, а не поле exercises в Workout.
     */
    public function getRecentExercises(Request $request)
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['message' => 'Требуется авторизация.'], 401);
            }

            $searchQuery = $request->query('searchQuery');

            $workouts = Workout::where('user_id', $userId)
                ->orderBy('date', 'desc')
                ->take(10)
                ->with('exercises.exercise')
                ->get();

            $recentExercisesSet = [];
            $recentExercises    = [];

            foreach ($workouts as $workout) {
                foreach ($workout->exercises as $we) {
                    $exercise = $we->exercise;
                    if (!$exercise) {
                        continue;
                    }

                    if (!empty($searchQuery) && stripos($exercise->name, $searchQuery) === false) {
                        continue;
                    }

                    if (!in_array($exercise->id, $recentExercisesSet)) {
                        $recentExercisesSet[] = $exercise->id;
                        $recentExercises[]    = $exercise;
                    }

                    if (count($recentExercises) >= 3) {
                        break;
                    }
                }
                if (count($recentExercises) >= 3) {
                    break;
                }
            }

            return response()->json($recentExercises);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении последних упражнений: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении последних упражнений.'], 500);
        }
    }

    /**
     * Получение информации об упражнении.
     * Если нужно вычислять "bestWeight" и т.д. - идём через workout_exercises + exercise_sets.
     */
    public function getExerciseInfo(Request $request)
    {
        try {
            $exerciseId = $request->query('id');
            $userId     = $request->session()->get('userId');

            $exercise = Exercise::find($exerciseId);
            if (!$exercise) {
                return response()->json(['message' => 'Упражнение не найдено.'], 404);
            }

            $userExerciseXP = 0;
            $user           = null;

            // Пример, если у вас pivot "user_exercise_experience"
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $exercisePivot = $user->exercises()->where('exercise_id', $exerciseId)->first();
                    if ($exercisePivot) {
                        $userExerciseXP = $exercisePivot->pivot->experience ?? 0;
                    }
                }
            }

            $bestWeight      = 0;
            $bestWeightLevel = 0;
            $bestXP          = 0;

            if ($user && $userId) {
                $workoutExercises = WorkoutExercise::where('exercise_id', $exerciseId)
                    ->whereHas('workout', function($q) use($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->with('sets')
                    ->get();

                $gender      = ($user->gender === 'female') ? 'female' : 'male';
                $avgWeight   = ($gender === 'female') ? 60 : 70;
                $weightFactor= ($user->weight) ? ($user->weight / $avgWeight) : 1;

                $minW = ($gender === 'male') ? $exercise->min_weight_male : $exercise->min_weight_female;
                $maxW = ($gender === 'male') ? $exercise->max_weight_male : $exercise->max_weight_female;

                $adjMinWeight = $minW * $weightFactor;
                $adjMaxWeight = $maxW * $weightFactor;

                foreach ($workoutExercises as $we) {
                    foreach ($we->sets as $set) {
                        if ($set->weight > $bestWeight) {
                            $bestWeight = $set->weight;
                        }
                        $lvl = $this->calculateWeightLevel($set->weight, $adjMinWeight, $adjMaxWeight);
                        if ($lvl > $bestWeightLevel) {
                            $bestWeightLevel = $lvl;
                        }

                        // Если хотите использовать новую формулу, замените на calculateSetXP(...)
                        $rpeBonus = ($set->rpe > 5) ? ($set->rpe - 5) * 0.05 : 0;
                        $setXP    = $lvl * $set->reps * (1 + $rpeBonus);
                        if ($setXP > $bestXP) {
                            $bestXP = round($setXP);
                        }
                    }
                }
            }

            return response()->json([
                'id'                => $exercise->id,
                'name'              => $exercise->name,
                'videoUrl'          => $exercise->video_url,
                'thumbnailUrl'      => $exercise->thumbnail_url,
                'minWeightMale'     => $exercise->min_weight_male,
                'maxWeightMale'     => $exercise->max_weight_male,
                'minWeightFemale'   => $exercise->min_weight_female,
                'maxWeightFemale'   => $exercise->max_weight_female,
                'description'       => $exercise->description,
                'musclePercentages' => $exercise->musclePercentages->mapWithKeys(function($mp) {
                    return [$mp->name => $mp->pivot->percentages];
                }),
                'muscleFilters'     => $exercise->muscleFilters->pluck('name'),
                'tips'              => $exercise->tips,
                'userExerciseXP'    => $userExerciseXP,
                'bestWeight'        => $bestWeight,
                'bestWeightLevel'   => $bestWeightLevel,
                'bestXP'            => $bestXP
            ]);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении информации об упражнении: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении информации об упражнении.'], 500);
        }
    }

    /**
     * Добавление тренировки:
     * - Создаём workout
     * - Создаём workout_exercises
     * - Создаём exercise_sets
     * - Рассчитываем XP
     * - Обновляем общий опыт пользователя
     * - Обновляем pivot-таблицы "user_muscles_experience" и "user_exercise_experience"
     */
    public function addWorkout(Request $request)
    {
        Log::info('Получен запрос на добавление тренировки:', $request->all());

        $userId = Auth::id();
        if (!$userId) {
            Log::warning('Попытка доступа без авторизации.');
            return response()->json(['message' => 'Необходима авторизация.'], 401);
        }

        try {
            $exercises        = $request->input('exercises', []);
            $totalWorkoutTime = $request->input('totalWorkoutTime', '');

            // Валидируем сеты
            foreach ($exercises as $exerciseEntry) {
                foreach ($exerciseEntry['sets'] as $set) {
                    if ($set['weight'] <= 0 || $set['reps'] <= 0 || $set['rpe'] < 5 || $set['rpe'] > 10) {
                        return response()->json(['message' => 'Некорректные данные в подходах.'], 400);
                    }
                }
            }

            // Создаём тренировку
            $workout = Workout::create([
                'user_id'           => $userId,
                'date'              => now(),
                'total_experience'  => 0,
                'exercises_count'   => 0,
                'total_workout_time'=> $totalWorkoutTime,
            ]);

            $user = User::find($userId);
            $totalXP    = 0;
            $muscleXP   = [];  // Временный массив { 'Грудь' => X, 'Трицепс' => Y }
            $exerciseXP = [];  // Временный массив { exerciseId => XP }

            // Создаём workout_exercises + exercise_sets
            foreach ($exercises as $exData) {
                $exerciseId = $exData['exerciseId'];
                $notes      = $exData['notes'] ?? '';

                $exercise = Exercise::find($exerciseId);
                if (!$exercise) {
                    continue;
                }

                $workoutExercise = WorkoutExercise::create([
                    'workout_id' => $workout->id,
                    'exercise_id'=> $exerciseId,
                    'sets_count' => count($exData['sets']),
                ]);

                foreach ($exData['sets'] as $setData) {
                    $weight = $setData['weight'];
                    $reps   = $setData['reps'];
                    $rpe    = $setData['rpe'];

                    ExerciseSet::create([
                        'workout_exercise_id' => $workoutExercise->id,
                        'weight' => $weight,
                        'reps'   => $reps,
                        'rpe'    => $rpe
                    ]);

                    // Считаем XP по новой формуле
                    $setXP = $this->calculateSetXP($weight, $reps, $rpe, $exercise, $user);
                    $totalXP += $setXP;

                    // Распределяем XP по мышцам (если нужно)
                    if ($exercise->musclePercentages && $exercise->musclePercentages->count() > 0) {
                        foreach ($exercise->musclePercentages as $mp) {
                            $muscleName  = $mp->name;
                            $percent     = $mp->pivot->percentages;
                            $xpForMuscle = ($setXP * $percent) / 100;

                            if (!isset($muscleXP[$muscleName])) {
                                $muscleXP[$muscleName] = 0;
                            }
                            $muscleXP[$muscleName] += $xpForMuscle;
                        }
                    }

                    // Копим опыт для упражнения
                    $exKey = (int) $exercise->id;
                    if (!isset($exerciseXP[$exKey])) {
                        $exerciseXP[$exKey] = 0;
                    }
                    $exerciseXP[$exKey] += $setXP;
                }
            }

            // Обновляем саму тренировку
            $workout->exercises_count  = count($exercises);
            $workout->total_experience = $totalXP;
            $workout->save();

            // Обновляем общий опыт пользователя
            $user->experience += $totalXP;

            // -----------------------------
            //  Теперь обновляем опыт мышц
            // -----------------------------
            foreach ($muscleXP as $muscleName => $xpVal) {
                // Пытаемся найти Muscle по имени
                $foundMuscle = Muscle::where('name', $muscleName)->first();
                if (!$foundMuscle) {
                    // Если не нашли в таблице "muscles", пропускаем
                    continue;
                }

                // Ищем текущий pivot
                $pivot = $user->muscles()->where('muscle_id', $foundMuscle->id)->first();
                $oldExp = $pivot ? $pivot->pivot->experience : 0;
                $newExp = $oldExp + $xpVal;

                // Обновляем запись в user_muscles_experience
                if ($pivot) {
                    $user->muscles()->updateExistingPivot($foundMuscle->id, [
                        'experience' => $newExp
                    ]);
                } else {
                    // Если ещё не было pivot-а, attach
                    $user->muscles()->attach($foundMuscle->id, [
                        'experience' => $newExp
                    ]);
                }
            }

            // -----------------------------
            //  Обновляем опыт упражнений
            // -----------------------------
            foreach ($exerciseXP as $exId => $exXP) {
                // Находим pivot
                $exercisePivot = $user->exercises()->where('exercise_id', $exId)->first();
                $oldExp = $exercisePivot ? $exercisePivot->pivot->experience : 0;
                $newExp = $oldExp + $exXP;

                if ($exercisePivot) {
                    $user->exercises()->updateExistingPivot($exId, [
                        'experience' => $newExp
                    ]);
                } else {
                    $user->exercises()->attach($exId, [
                        'experience' => $newExp
                    ]);
                }
            }

            $user->save();

            return response()->json([
                'message'       => 'Тренировка успешно сохранена!',
                'xpGained'      => round($totalXP),
                'newExperience' => $user->experience,
            ]);
        } catch (\Exception $err) {
            Log::error('Ошибка при сохранении тренировки: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при сохранении тренировки.'], 500);
        }
    }

    /**
     * Пример: получение истории всех тренировок пользователя
     * с подгруженными упражнениями и сетами
     */
    public function getWorkouts(Request $request)
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                Log::info('Попытка доступа без авторизации getWorkouts');
                return response()->json(['message' => 'Необходима авторизация.'], 401);
            }

            $workouts = Workout::where('user_id', $userId)
                ->orderBy('date', 'desc')
                ->with([
                    'exercises.exercise' => function($q) {
                        // Можно сузить набор полей
                    },
                    'exercises.sets'
                ])
                ->get();

            return response()->json($workouts);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении тренировок: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении тренировок.'], 500);
        }
    }

    /**
     * Получение данных конкретной тренировки
     */
    public function getWorkout(Request $request)
    {
        try {
            $workoutId = $request->query('id');
            $userId    = $request->session()->get('userId');

            $workout = Workout::where('id', $workoutId)
                ->where('user_id', $userId)
                ->with(['exercises.exercise', 'exercises.sets'])
                ->first();

            if (!$workout) {
                return response()->json(['message' => 'Тренировка не найдена.'], 404);
            }

            return response()->json($workout);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении тренировки: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении тренировки.'], 500);
        }
    }

    /**
     * Получение истории выполнения конкретного упражнения (последняя тренировка, setNumber-й подход)
     */
    public function getExerciseHistory(Request $request)
    {
        try {
            $exerciseId = $request->query('exerciseId');
            $setNumber  = (int)$request->query('setNumber', 1);
            $userId     = $request->session()->get('userId');

            $workoutExercise = WorkoutExercise::where('exercise_id', $exerciseId)
                ->whereHas('workout', function($q) use($userId) {
                    $q->where('user_id', $userId);
                })
                ->orderByDesc('id')
                ->with('sets')
                ->first();

            if (!$workoutExercise) {
                return response()->json(['message' => 'Нет предыдущих данных для этого упражнения.']);
            }

            $sets = $workoutExercise->sets;
            if ($sets->count() < $setNumber) {
                return response()->json(['message' => 'Нет данных для указанного сета.']);
            }

            $previousSet = $sets[$setNumber - 1];
            return response()->json(['previousSet' => $previousSet]);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении истории выполнения упражнения: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении истории выполнения упражнения.'], 500);
        }
    }

    /**
     * Получение заметок по упражнению (пример).
     * Если вы храните "notes" в workout_exercises, ищем последнюю запись, где exercise_id = ...
     */
    public function getExerciseNotes(Request $request)
    {
        try {
            $exerciseId = $request->query('exerciseId');
            $userId     = $request->session()->get('userId');

            $workoutExercise = WorkoutExercise::where('exercise_id', $exerciseId)
                ->whereHas('workout', function($q) use($userId) {
                    $q->where('user_id', $userId);
                })
                ->orderByDesc('id')
                ->first();

            if (!$workoutExercise) {
                return response()->json(['notes' => ''], 200);
            }

            // Если есть поле notes в workout_exercises:
            // $notes = $workoutExercise->notes;
            // return response()->json(['notes' => $notes ?? ''], 200);

            return response()->json(['notes' => ''], 200);

        } catch (\Exception $error) {
            Log::error('Ошибка при получении заметок по упражнению: ' . $error->getMessage());
            return response()->json(['message' => 'Ошибка сервера при получении заметок.'], 500);
        }
    }

    /**
     * Начало тренировки по программе
     */
    public function startProgramWorkout(Request $request)
    {
        try {
            $programId = $request->input('programId');
            $userId    = $request->session()->get('userId');

            $program = Program::where('id', $programId)
                ->where('user_id', $userId)
                ->with('exercises.exercise')
                ->first();

            if (!$program) {
                return response()->json(['message' => 'Программа не найдена.'], 404);
            }

            return response()->json(['program' => $program]);
        } catch (\Exception $err) {
            Log::error('Ошибка при начале тренировки по программе: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при начале тренировки по программе.'], 500);
        }
    }

    /**
     * ------------------------------
     * Вспомогательные функции
     * ------------------------------
     */

    /**
     * Рассчитываем XP для 1 сета
     */
    private function calculateSetXP($weight, $reps, $rpe, Exercise $exercise, User $user)
    {
        $gender    = ($user->gender === 'female') ? 'female' : 'male';
        $avgWeight = ($gender === 'female') ? 60 : 70;
        $userWeight= $user->weight ?? $avgWeight;
        $factor    = $userWeight / $avgWeight;

        $minW = ($gender === 'male') ? $exercise->min_weight_male : $exercise->min_weight_female;
        $maxW = ($gender === 'male') ? $exercise->max_weight_male : $exercise->max_weight_female;
        $adjMin = $minW * $factor;
        $adjMax = $maxW * $factor;

        $weightLevel = $this->calculateWeightLevel($weight, $adjMin, $adjMax);

        $baseXP  = $weightLevel * $reps;

        $rpeBonus = 0;
        if ($rpe > 5) {
            $percent = ($rpe - 5) * 0.05;
            $rpeBonus = $baseXP * $percent;
        }

        $multiRepFactor = 1.0;
        if ($reps >= 13 && $reps <= 15) {
            $multiRepFactor = 0.8;
        } elseif ($reps >= 16) {
            $multiRepFactor = 0.5;
        }

        return round(($baseXP + $rpeBonus) * $multiRepFactor);
    }

    /**
     * Пример "глобальной" функции расчёта всей тренировки (если нужно).
     */
    private function calculateWorkoutXP(array $exercises, User $user)
    {
        $totalXP    = 0;
        $muscleXP   = [];
        $exerciseXP = [];

        // ... Логика аналогична тому, что мы делаем в addWorkout(...)
        // Можно оставить как пример для seeding
        return [
            'xpGained'   => 0,
            'muscleXP'   => [],
            'exerciseXP' => []
        ];
    }
    /**
     * Уровень нагрузки (1..10)
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
