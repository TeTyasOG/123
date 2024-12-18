<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function getExercises(Request $request)
    {
        $query = Exercise::query();

        $muscleGroup = $request->query('muscleGroup');
        $searchQuery = $request->query('searchQuery');

        if ($muscleGroup && $muscleGroup !== '' && $muscleGroup !== 'ВСЕ МЫШЦЫ') {
            $query->where('muscleFilter', $muscleGroup);
        }

        if ($searchQuery && $searchQuery !== '') {
            $query->where('name', 'regexp', $searchQuery, 'i');
        }

        $exercises = $query->get();
        return response()->json($exercises);
    }

    public function getRecentExercises(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) return response()->json(['message' => 'Требуется авторизация.'], 401);

        $searchQuery = $request->query('searchQuery');

        $workouts = Workout::where('userId', $userId)->orderBy('date', 'desc')->limit(10)->get();

        $recentExercisesSet = [];
        $recentExercises = [];

        foreach ($workouts as $workout) {
            foreach ($workout->exercises as $exerciseEntry) {
                $exercise = Exercise::find($exerciseEntry['exerciseId']);
                if (!$exercise) continue;

                if ($searchQuery && $searchQuery !== '' && stripos($exercise->name, $searchQuery) === false) {
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
    }

    public function getExerciseInfo(Request $request)
    {
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
            if ($user && $user->exerciseExperience) {
                $xp = $user->exerciseExperience[$exerciseId] ?? 0;
                if ($xp) $userExerciseXP = $xp;
            }
        }

        // Рассчет bestWeight, bestWeightLevel, bestXP
        $bestWeight = 0;
        $bestWeightLevel = 0;
        $bestXP = 0;

        if ($user && $userId) {
            $workouts = Workout::where('userId', $userId)->where('exercises.exerciseId', $exerciseId)->get();

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

                        $rpeBonus = ($s['rpe'] > 5) ? ($s['rpe'] - 5) * 0.05 : 0;
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
    }

    private function calculateWeightLevel($weight, $minWeight, $maxWeight)
    {
        if ($weight <= $minWeight) return 1;
        if ($weight >= $maxWeight) return 10;
        $ratio = ($weight - $minWeight) / ($maxWeight - $minWeight);
        return round($ratio * 9 + 1);
    }
}
