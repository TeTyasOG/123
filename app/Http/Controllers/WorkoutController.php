<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\Program;
use Illuminate\Support\Facades\Log;

class WorkoutController extends Controller
{
    // Получение списка упражнений
    public function getExercises(Request $request)
    {
        try {
            $muscleGroup = $request->query('muscleGroup');
            $searchQuery = $request->query('searchQuery');
            
            $query = Exercise::query();

            if (!empty($muscleGroup) && $muscleGroup !== 'ВСЕ МЫШЦЫ') {
                $query->where('muscleFilter', $muscleGroup);
            }

            if (!empty($searchQuery)) {
                // Если используется MongoDB, можно применить regex:
                // $regex = new \MongoDB\BSON\Regex($searchQuery, 'i');
                // $query->where('name', 'regexp', $regex);
                
                // Если regex недоступен, можно использовать like, если данные позволяют:
                $query->where('name', 'like', '%'.$searchQuery.'%');
            }

            $exercises = $query->get();
            return response()->json($exercises);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении упражнений: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении упражнений.'], 500);
        }
    }

    // Получение последних упражнений
    public function getRecentExercises(Request $request)
    {
        try {
            $userId = $request->session()->get('userId');
            $searchQuery = $request->query('searchQuery');

            $workouts = Workout::where('userId', $userId)
                ->orderBy('date', 'desc')
                ->take(10)
                ->with('exercises.exerciseId')
                ->get();

            $recentExercisesSet = [];
            $recentExercises = [];

            foreach ($workouts as $workout) {
                foreach ($workout->exercises as $exerciseEntry) {
                    $exercise = $exerciseEntry['exerciseId'];
                    if (!$exercise) continue;

                    if (!empty($searchQuery) && stripos($exercise->name, $searchQuery) === false) {
                        continue;
                    }

                    if (!in_array((string)$exercise->_id, $recentExercisesSet)) {
                        $recentExercisesSet[] = (string)$exercise->_id;
                        $recentExercises[] = $exercise;
                    }

                    if (count($recentExercises) >= 3) break;
                }
                if (count($recentExercises) >= 3) break;
            }

            return response()->json($recentExercises);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении последних упражнений: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении последних упражнений.'], 500);
        }
    }

    // Получение информации об упражнении
    public function getExerciseInfo(Request $request)
    {
        try {
            $exerciseId = $request->query('id');
            $userId = $request->session()->get('userId');

            $exercise = Exercise::find($exerciseId);
            if (!$exercise) {
                return response()->json(['message' => 'Упражнение не найдено.'], 404);
            }

            $userExerciseXP = 0;
            $user = null;
            if ($userId) {
                $user = User::find($userId);
                if ($user && !empty($user->exerciseExperience)) {
                    $exIdStr = (string)$exerciseId;
                    if (isset($user->exerciseExperience[$exIdStr])) {
                        $userExerciseXP = $user->exerciseExperience[$exIdStr];
                    }
                }
            }

            $bestWeight = 0;
            $bestWeightLevel = 0;
            $bestXP = 0;

            if ($user && $userId) {
                $workouts = Workout::where('userId', $userId)
                    ->where('exercises.exerciseId', $exerciseId)
                    ->get();

                $gender = ($user && $user->gender === 'female') ? 'female' : 'male';
                $avgWeight = ($gender === 'female') ? 60 : 70;
                $weightFactor = ($user && $user->weight) ? $user->weight / $avgWeight : 1;

                $minW = ($gender === 'male') ? $exercise->minWeightMale : $exercise->minWeightFemale;
                $maxW = ($gender === 'male') ? $exercise->maxWeightMale : $exercise->maxWeightFemale;

                $adjMinWeight = $minW * $weightFactor;
                $adjMaxWeight = $maxW * $weightFactor;

                foreach ($workouts as $w) {
                    foreach ($w->exercises as $exData) {
                        if ((string)$exData['exerciseId'] !== (string)$exerciseId) continue;
                        foreach ($exData['sets'] as $s) {
                            if ($s['weight'] > $bestWeight) $bestWeight = $s['weight'];
                            $lvl = $this->calculateWeightLevel($s['weight'], $adjMinWeight, $adjMaxWeight);
                            if ($lvl > $bestWeightLevel) $bestWeightLevel = $lvl;

                            $rpeBonus = $s['rpe'] > 5 ? ($s['rpe'] - 5) * 0.05 : 0;
                            $setXP = $lvl * $s['reps'] * (1 + $rpeBonus);
                            if ($setXP > $bestXP) $bestXP = round($setXP);
                        }
                    }
                }
            }

            return response()->json([
                'name' => $exercise->name,
                'englishName' => $exercise->englishName,
                'videoUrl' => $exercise->videoUrl,
                'thumbnailUrl' => $exercise->thumbnailUrl,
                'musclePercentages' => $exercise->musclePercentages,
                'muscleFilter' => $exercise->muscleFilter,
                'minWeightMale' => $exercise->minWeightMale,
                'maxWeightMale' => $exercise->maxWeightMale,
                'minWeightFemale' => $exercise->minWeightFemale,
                'maxWeightFemale' => $exercise->maxWeightFemale,
                'description' => $exercise->description,
                'tips' => $exercise->tips,
                'userExerciseXP' => $userExerciseXP,
                'bestWeight' => $bestWeight,
                'bestWeightLevel' => $bestWeightLevel,
                'bestXP' => $bestXP
            ]);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении информации об упражнении: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении информации об упражнении.'], 500);
        }
    }

    // Добавление тренировки
    public function addWorkout(Request $request)
    {
        try {
            $exercises = $request->input('exercises', []);
            $totalWorkoutTime = $request->input('totalWorkoutTime', '');
            $userId = $request->session()->get('userId');

            // Валидация сетов
            foreach ($exercises as $exerciseEntry) {
                foreach ($exerciseEntry['sets'] as $set) {
                    if ($set['weight'] <= 0 || $set['reps'] <= 0 || $set['rpe'] < 1 || $set['rpe'] > 10) {
                        return response()->json(['message' => 'Некорректные данные в подходах.'], 400);
                    }
                }
            }

            $newWorkout = new Workout([
                'userId' => $userId,
                'exercises' => $exercises,
                'date' => now()
            ]);

            $newWorkout->save();

            $user = User::find($userId);
            $xpData = $this->calculateWorkoutXP($exercises, $user);
            $xpGained = $xpData['xpGained'];
            $muscleXP = $xpData['muscleXP'];
            $exerciseXP = $xpData['exerciseXP'];

            $user->experience += $xpGained;

            // Инициализация полей
            if (empty($user->muscleExperience)) $user->muscleExperience = [];
            if (empty($user->muscleLevels)) $user->muscleLevels = [];

            // Обновление опыта мышц
            foreach ($muscleXP as $muscle => $xpVal) {
                $currentXP = isset($user->muscleExperience[$muscle]) ? $user->muscleExperience[$muscle] : 0;
                $user->muscleExperience[$muscle] = $currentXP + $xpVal;
                $user->muscleLevels[$muscle] = $this->calculateMuscleLevel($user->muscleExperience[$muscle]);
            }

            // Обновление опыта упражнений
            if (empty($user->exerciseExperience)) $user->exerciseExperience = [];
            if (empty($user->exerciseLevels)) $user->exerciseLevels = [];

            foreach ($exerciseXP as $exIdStr => $exXP) {
                $currentExXP = isset($user->exerciseExperience[$exIdStr]) ? $user->exerciseExperience[$exIdStr] : 0;
                $user->exerciseExperience[$exIdStr] = $currentExXP + $exXP;
                $user->exerciseLevels[$exIdStr] = $this->calculateLevel($user->exerciseExperience[$exIdStr]);
            }

            $newLevel = $this->calculateLevel($user->experience);
            if ($newLevel > $user->level) {
                $user->level = $newLevel;
                if (empty($user->achievements)) {
                    $user->achievements = [];
                }
                $user->achievements[] = "Достигнут уровень {$newLevel}";
            }

            $user->save();

            // Обновляем данные тренировки
            $newWorkout->totalXP = $xpGained;
            $newWorkout->exercisesCount = count($exercises);
            $newWorkout->totalWorkoutTime = $totalWorkoutTime;
            $newWorkout->save();

            return response()->json([
                'message' => 'Тренировка успешно сохранена!',
                'xpGained' => $xpGained,
                'newExperience' => $user->experience,
                'newLevel' => $user->level
            ]);
        } catch (\Exception $err) {
            Log::error('Ошибка при сохранении тренировки: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при сохранении тренировки.'], 500);
        }
    }

    // Получение истории тренировок
    public function getWorkouts(Request $request)
    {
        try {
            $userId = $request->session()->get('userId');
            $workouts = Workout::where('userId', $userId)
                ->orderBy('date', 'desc')
                ->with('exercises.exerciseId')
                ->get();

            return response()->json($workouts);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении тренировок: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении тренировок.'], 500);
        }
    }

    // Получение данных конкретной тренировки
    public function getWorkout(Request $request)
    {
        try {
            $workoutId = $request->query('id');
            $userId = $request->session()->get('userId');

            $workout = Workout::where('_id', $workoutId)
                ->where('userId', $userId)
                ->with('exercises.exerciseId')
                ->first();

            if ($workout) {
                return response()->json($workout);
            } else {
                return response()->json(['message' => 'Тренировка не найдена.'], 404);
            }
        } catch (\Exception $err) {
            Log::error('Ошибка при получении тренировки: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении тренировки.'], 500);
        }
    }

    // Получение истории выполнения упражнения
    public function getExerciseHistory(Request $request)
    {
        try {
            $exerciseId = $request->query('exerciseId');
            $setNumber = (int)$request->query('setNumber', 1);
            $userId = $request->session()->get('userId');

            $workout = Workout::where('userId', $userId)
                ->where('exercises.exerciseId', $exerciseId)
                ->orderBy('date', 'desc')
                ->first();

            if (!$workout) {
                return response()->json(['message' => 'Нет предыдущих данных для этого упражнения.']);
            }

            $exerciseData = null;
            foreach ($workout->exercises as $ex) {
                if ((string)$ex['exerciseId'] === (string)$exerciseId) {
                    $exerciseData = $ex;
                    break;
                }
            }

            if (!$exerciseData || empty($exerciseData['sets']) || count($exerciseData['sets']) < $setNumber) {
                return response()->json(['message' => 'Нет данных для указанного сета.']);
            }

            $previousSet = $exerciseData['sets'][$setNumber - 1];

            return response()->json(['previousSet' => $previousSet]);
        } catch (\Exception $err) {
            Log::error('Ошибка при получении истории выполнения упражнения: ' . $err->getMessage());
            return response()->json(['message' => 'Ошибка при получении истории выполнения упражнения.'], 500);
        }
    }

    // Получение заметок по упражнению
    public function getExerciseNotes(Request $request)
    {
        try {
            $exerciseId = $request->query('exerciseId');
            $userId = $request->session()->get('userId');

            $workouts = Workout::where('userId', $userId)->orderBy('date', 'desc')->get();

            if (!$workouts || count($workouts) === 0) {
                return response()->json(['notes' => ''], 200);
            }

            foreach ($workouts as $workout) {
                foreach ($workout->exercises as $exerciseEntry) {
                    if ((string)$exerciseEntry['exerciseId'] === (string)$exerciseId && !empty($exerciseEntry['notes'])) {
                        return response()->json(['notes' => $exerciseEntry['notes']], 200);
                    }
                }
            }

            return response()->json(['notes' => ''], 200);
        } catch (\Exception $error) {
            Log::error('Ошибка при получении заметок по упражнению: ' . $error->getMessage());
            return response()->json(['message' => 'Ошибка сервера при получении заметок.'], 500);
        }
    }

    // Начало тренировки по программе
    public function startProgramWorkout(Request $request)
    {
        try {
            $programId = $request->input('programId');
            $userId = $request->session()->get('userId');

            $program = Program::where('_id', $programId)
                ->where('userId', $userId)
                ->with('exercises.exerciseId')
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

    // Вспомогательные функции
    private function calculateWorkoutXP(array $exercises, User $user)
    {
        $totalXP = 0;
        $averageWeightMale = 70;
        $averageWeightFemale = 60;

        $userWeight = $user->weight ?? $averageWeightMale;
        $userGender = $user->gender ?? 'male';

        if ($userGender === 'male') {
            $averageWeight = $averageWeightMale;
        } elseif ($userGender === 'female') {
            $averageWeight = $averageWeightFemale;
        } else {
            $averageWeight = $averageWeightMale;
        }

        $weightAdjustmentFactor = $userWeight / $averageWeight;

        $muscleXP = [];
        $exerciseXP = [];

        foreach ($exercises as $exerciseEntry) {
            $exercise = Exercise::find($exerciseEntry['exerciseId']);
            if (!$exercise) continue;

            if ($userGender === 'male') {
                $minWeight = $exercise->minWeightMale;
                $maxWeight = $exercise->maxWeightMale;
            } else {
                $minWeight = $exercise->minWeightFemale;
                $maxWeight = $exercise->maxWeightFemale;
            }

            $minWeight *= $weightAdjustmentFactor;
            $maxWeight *= $weightAdjustmentFactor;

            foreach ($exerciseEntry['sets'] as $set) {
                $weightLevel = 1;
                if ($set['weight'] <= $minWeight) {
                    $weightLevel = 1;
                } elseif ($set['weight'] >= $maxWeight) {
                    $weightLevel = 10;
                } else {
                    $ratio = ($set['weight'] - $minWeight) / ($maxWeight - $minWeight);
                    $weightLevel = round($ratio * 9 + 1);
                }

                $setXP = $weightLevel * $set['reps'];
                if ($set['rpe'] > 5) {
                    $additionalPercent = ($set['rpe'] - 5) * 5;
                    $setXP += ($setXP * $additionalPercent) / 100;
                }

                $totalXP += $setXP;
                $percentages = $exercise->musclePercentages ?? [];

                foreach ($percentages as $muscleName => $percent) {
                    $xpForMuscle = ($setXP * $percent) / 100;
                    if (!isset($muscleXP[$muscleName])) {
                        $muscleXP[$muscleName] = 0;
                    }
                    $muscleXP[$muscleName] += $xpForMuscle;
                }

                $exIdStr = (string)$exercise->_id;
                if (!isset($exerciseXP[$exIdStr])) {
                    $exerciseXP[$exIdStr] = 0;
                }
                $exerciseXP[$exIdStr] += $setXP;
            }
        }

        return [
            'xpGained' => round($totalXP),
            'muscleXP' => $muscleXP,
            'exerciseXP' => $exerciseXP
        ];
    }

    private function calculateLevel($experience)
    {
        if ($experience < 8600) {
            // Уровни 1–20
            return floor(($experience - 300) / 200) + 1;
        } elseif ($experience < 1800000) {
            // Уровни 21–70
            return floor(pow(($experience - 8600) / 12, 1 / 1.5)) + 21;
        } else {
            // Уровни 71–100
            return floor(70 + log(($experience - 1800000) / 30000) / log(1.08));
        }
    }

    private function calculateMuscleLevel($experience)
    {
        $A = 50;
        $B = 500;

        for ($level = 1; $level <= 20; $level++) {
            $xpForNextLevel = $A * ($level ** 2) + $B;
            if ($experience < $xpForNextLevel) {
                return $level;
            }
            $experience -= $xpForNextLevel;
        }
        return 20; // Максимальный уровень
    }

    private function calculateWeightLevel($weight, $minWeight, $maxWeight)
    {
        if ($weight <= $minWeight) return 1;
        if ($weight >= $maxWeight) return 10;
        $ratio = ($weight - $minWeight) / ($maxWeight - $minWeight);
        return round($ratio * 9 + 1);
    }
}
