<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function addWorkout(Request $request)
    {
        $request->validate([
            'exercises' => 'required|array',
            // totalWorkoutTime - опционально
        ]);

        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $exercises = $request->exercises;
        // Валидация сетов
        foreach ($exercises as $exerciseEntry) {
            foreach ($exerciseEntry['sets'] as $set) {
                if ($set['weight'] <= 0 || $set['reps'] <= 0 || $set['rpe'] < 1 || $set['rpe'] > 10) {
                    return response()->json(['message' => 'Некорректные данные в подходах.'], 400);
                }
            }
        }

        $newWorkout = Workout::create([
            'userId' => $userId,
            'exercises' => $exercises,
            'date' => now(),
        ]);

        $user = User::find($userId);
        [$xpGained, $muscleXP, $exerciseXP] = $this->calculateWorkoutXP($exercises, $user);

        $user->experience += $xpGained;
        $user->muscleExperience = $user->muscleExperience ?? [];
        $user->muscleLevels = $user->muscleLevels ?? [];

        // Обновление muscleExperience и muscleLevels
        foreach ($muscleXP as $muscle => $xp) {
            $currentXP = $user->muscleExperience[$muscle] ?? 0;
            $user->muscleExperience[$muscle] = $currentXP + $xp;
            $user->muscleLevels[$muscle] = $this->calculateMuscleLevel($user->muscleExperience[$muscle]);
        }

        $user->exerciseExperience = $user->exerciseExperience ?? [];
        $user->exerciseLevels = $user->exerciseLevels ?? [];

        foreach ($exerciseXP as $exId => $xp) {
            $currentXP = $user->exerciseExperience[$exId] ?? 0;
            $user->exerciseExperience[$exId] = $currentXP + $xp;
            $user->exerciseLevels[$exId] = $this->calculateLevel($user->exerciseExperience[$exId]);
        }

        $newLevel = $this->calculateLevel($user->experience);
        if ($newLevel > $user->level) {
            $user->level = $newLevel;
            $ach = $user->achievements ?? [];
            $ach[] = "Достигнут уровень $newLevel";
            $user->achievements = $ach;
        }

        $user->save();

        // Обновляем данные тренировки
        $newWorkout->totalXP = $xpGained;
        $newWorkout->exercisesCount = count($exercises);
        $newWorkout->totalWorkoutTime = $request->input('totalWorkoutTime', '');
        $newWorkout->save();

        return response()->json([
            'message' => 'Тренировка успешно сохранена!',
            'xpGained' => $xpGained,
            'newExperience' => $user->experience,
            'newLevel' => $user->level
        ]);
    }

    public function getWorkouts(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $workouts = Workout::where('userId', $userId)->orderBy('date', 'desc')->get();
        return response()->json($workouts);
    }

    public function getWorkout(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $workoutId = $request->query('id');
        $workout = Workout::where('_id', $workoutId)->where('userId', $userId)->first();

        if ($workout) {
            return response()->json($workout);
        } else {
            return response()->json(['message' => 'Тренировка не найдена.'], 404);
        }
    }

    public function getExerciseHistory(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $exerciseId = $request->query('exerciseId');
        $setNumber = (int)$request->query('setNumber', 1);

        $workouts = Workout::where('userId', $userId)->where('exercises.exerciseId', $exerciseId)
            ->orderBy('date', 'desc')
            ->limit(1)
            ->get();

        if ($workouts->isEmpty()) {
            return response()->json(['message' => 'Нет предыдущих данных для этого упражнения.']);
        }

        $workout = $workouts->first();
        $exerciseData = collect($workout->exercises)->firstWhere('exerciseId', new \MongoDB\BSON\ObjectId($exerciseId));

        if (!$exerciseData || !isset($exerciseData['sets']) || count($exerciseData['sets']) < $setNumber) {
            return response()->json(['message' => 'Нет данных для указанного сета.']);
        }

        $previousSet = $exerciseData['sets'][$setNumber - 1];
        return response()->json(['previousSet' => $previousSet]);
    }

    public function getExerciseNotes(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $exerciseId = $request->query('exerciseId');
        $workouts = Workout::where('userId', $userId)->orderBy('date', 'desc')->get();

        if ($workouts->isEmpty()) {
            return response()->json(['notes' => ''], 200);
        }

        foreach ($workouts as $workout) {
            $exerciseEntry = collect($workout->exercises)->firstWhere('exerciseId', new \MongoDB\BSON\ObjectId($exerciseId));
            if ($exerciseEntry && !empty($exerciseEntry['notes'])) {
                return response()->json(['notes' => $exerciseEntry['notes']], 200);
            }
        }

        return response()->json(['notes' => ''], 200);
    }

    public function startProgramWorkout(Request $request)
    {
        $request->validate([
            'programId' => 'required|string'
        ]);

        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $program = \App\Models\Program::where('_id', $request->programId)->where('userId', $userId)->first();

        if (!$program) {
            return response()->json(['message' => 'Программа не найдена.'], 404);
        }

        return response()->json(['program' => $program]);
    }

    // Вспомогательные методы

    private function calculateWorkoutXP($exercises, $user)
    {
        $totalXP = 0;
        $averageWeightMale = 70;
        $averageWeightFemale = 60;

        $userWeight = $user->weight ?? $averageWeightMale;
        $userGender = $user->gender ?? 'male';

        $averageWeight = ($userGender === 'female') ? $averageWeightFemale : $averageWeightMale;
        $weightAdjustmentFactor = $userWeight / $averageWeight;

        $muscleXP = [];
        $exerciseXP = [];

        foreach ($exercises as $exerciseEntry) {
            $exercise = Exercise::find($exerciseEntry['exerciseId']);
            if (!$exercise) continue;

            $minWeight = ($userGender === 'female') ? $exercise->minWeightFemale : $exercise->minWeightMale;
            $maxWeight = ($userGender === 'female') ? $exercise->maxWeightFemale : $exercise->maxWeightMale;

            $minWeight *= $weightAdjustmentFactor;
            $maxWeight *= $weightAdjustmentFactor;

            foreach ($exerciseEntry['sets'] as $set) {
                $weight = $set['weight'];
                $reps = $set['reps'];
                $rpe = $set['rpe'];

                $weightLevel = 1;
                if ($weight <= $minWeight) {
                    $weightLevel = 1;
                } elseif ($weight >= $maxWeight) {
                    $weightLevel = 10;
                } else {
                    $weightLevel = round((($weight - $minWeight) / ($maxWeight - $minWeight)) * 9 + 1);
                }

                $setXP = $weightLevel * $reps;
                if ($rpe > 5) {
                    $additionalPercent = ($rpe - 5) * 5;
                    $setXP += ($setXP * $additionalPercent) / 100;
                }

                $totalXP += $setXP;

                $percentages = $exercise->musclePercentages ?? [];
                foreach ($percentages as $muscleName => $percent) {
                    $xpForMuscle = ($setXP * $percent) / 100;
                    $muscleXP[$muscleName] = ($muscleXP[$muscleName] ?? 0) + $xpForMuscle;
                }

                $exerciseXP[(string)$exercise->_id] = ($exerciseXP[(string)$exercise->_id] ?? 0) + $setXP;
            }
        }

        return [round($totalXP), $muscleXP, $exerciseXP];
    }

    private function calculateLevel($experience)
    {
        if ($experience < 8600) {
            return floor(($experience - 300) / 200) + 1;
        } elseif ($experience < 1800000) {
            return floor(pow(($experience - 8600) / 12, 1 / 1.5)) + 21;
        } else {
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
}
