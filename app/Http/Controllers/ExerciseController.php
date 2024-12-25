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

        // Фильтрация по группе мышц через связь muscleFilters
        if ($muscleGroup && $muscleGroup !== '' && $muscleGroup !== 'ВСЕ МЫШЦЫ') {
            $query->whereHas('muscleFilters', function ($q) use ($muscleGroup) {
                $q->where('name', $muscleGroup);
            });
        }

        // Фильтрация по названию упражнения
        if ($searchQuery && $searchQuery !== '') {
            // Вариант с LIKE (если нужно регистронезависимо — используйте lower() в запросе)
            $query->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Получаем все упражнения после фильтров
        $exercises = $query->get();

        // Для удобства можно сразу добавить поле 'musclePercentages' как объект {Мышца: Процент}
        // или оставить как есть — тогда фронт будет работать с коллекцией.
        $mapped = $exercises->map(function ($ex) {
            return [
                'id' => $ex->id,
                'name' => $ex->name,
                'videoUrl' => $ex->video_url,
                'thumbnailUrl' => $ex->thumbnail_url,
                'minWeightMale' => $ex->min_weight_male,
                'maxWeightMale' => $ex->max_weight_male,
                'minWeightFemale' => $ex->min_weight_female,
                'maxWeightFemale' => $ex->max_weight_female,
                'description' => $ex->description,
                // Преобразуем коллекцию musclePercentages в объект { 'Грудь': 60, 'Трицепс': 40 }
                'musclePercentages' => $ex->musclePercentages->mapWithKeys(function ($mp) {
                    return [$mp->name => $mp->pivot->percentages];
                }),
                // То же самое можно сделать для muscleFilters — вернуть массив названий
                'muscleFilters' => $ex->muscleFilters->pluck('name'),
            ];
        });

        return response()->json($mapped);
    }

    public function getRecentExercises(Request $request)
    {
        $userId = $request->session()->get('userId');
        if (!$userId) {
            return response()->json(['message' => 'Требуется авторизация.'], 401);
        }

        $searchQuery = $request->query('searchQuery');

        // Предполагается, что в Workout есть связь/поле, хранящее упражнения.
        // Если у вас пивот-таблица workout_exercises, нужно получать данные через нее.
        $workouts = Workout::where('userId', $userId)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        $recentExercisesSet = [];
        $recentExercises = [];

        // Здесь код основан на старой структуре MongoDB (массив exercises в документе workout).
        // Для MySQL обычно делают пивот-таблицу workout_exercises.
        // Ниже просто пример, как было:
        foreach ($workouts as $workout) {
            // $workout->exercises предполагается массивом c полями ['exerciseId' => X, 'sets' => [...]]
            // Замените на реальную логику, соответствующую вашей новой структуре.
            if (!is_array($workout->exercises)) continue;
            foreach ($workout->exercises as $exerciseEntry) {
                $exercise = Exercise::find($exerciseEntry['exerciseId'] ?? 0);
                if (!$exercise) continue;

                // Фильтр по названию
                if ($searchQuery && $searchQuery !== '' && stripos($exercise->name, $searchQuery) === false) {
                    continue;
                }

                // Проверка на уникальность
                if (!in_array($exercise->id, $recentExercisesSet)) {
                    $recentExercisesSet[] = $exercise->id;
                    $recentExercises[] = [
                        'id' => $exercise->id,
                        'name' => $exercise->name,
                        'videoUrl' => $exercise->video_url,
                        'thumbnailUrl' => $exercise->thumbnail_url,
                        'musclePercentages' => $exercise->musclePercentages->mapWithKeys(function ($mp) {
                            return [$mp->name => $mp->pivot->percentages];
                        }),
                        'muscleFilters' => $exercise->muscleFilters->pluck('name'),
                    ];
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
            // Если в модели User у вас есть поле/JSON exerciseExperience — используйте его
            if ($user && isset($user->exerciseExperience)) {
                $xp = $user->exerciseExperience[$exerciseId] ?? 0;
                if ($xp) $userExerciseXP = $xp;
            }
        }

        // Рассчет bestWeight, bestWeightLevel, bestXP
        $bestWeight = 0;
        $bestWeightLevel = 0;
        $bestXP = 0;

        if ($user && $userId) {
            // Поиск тренировок, где выполнялось данное упражнение
            // Аналогично, если есть пивот-таблица workout_exercises, нужно адаптировать
            $workouts = Workout::where('userId', $userId)
                ->where('exercises.exerciseId', $exerciseId)
                ->get();

            $gender = ($user->gender === 'female') ? 'female' : 'male';
            $avgWeight = ($gender === 'female') ? 60 : 70;
            $weightFactor = ($user->weight) ? $user->weight / $avgWeight : 1;

            $minW = ($gender === 'male') ? $exercise->min_weight_male : $exercise->min_weight_female;
            $maxW = ($gender === 'male') ? $exercise->max_weight_male : $exercise->max_weight_female;
            $adjMinWeight = $minW * $weightFactor;
            $adjMaxWeight = $maxW * $weightFactor;

            foreach ($workouts as $w) {
                if (!is_array($w->exercises)) continue;
                foreach ($w->exercises as $exData) {
                    if (($exData['exerciseId'] ?? null) != $exerciseId) continue;

                    foreach ($exData['sets'] as $s) {
                        if ($s['weight'] > $bestWeight) {
                            $bestWeight = $s['weight'];
                        }
                        $lvl = $this->calculateWeightLevel($s['weight'], $adjMinWeight, $adjMaxWeight);
                        if ($lvl > $bestWeightLevel) {
                            $bestWeightLevel = $lvl;
                        }

                        $rpeBonus = 0;
                        if (isset($s['rpe']) && $s['rpe'] > 5) {
                            $rpeBonus = ($s['rpe'] - 5) * 0.05;
                        }

                        $setXP = $lvl * ($s['reps'] ?? 0) * (1 + $rpeBonus);
                        if ($setXP > $bestXP) {
                            $bestXP = round($setXP);
                        }
                    }
                }
            }
        }

        // Возвращаем всю нужную информацию об упражнении
        return response()->json([
            'id' => $exercise->id,
            'name' => $exercise->name,
            'videoUrl' => $exercise->video_url,
            'thumbnailUrl' => $exercise->thumbnail_url,
            'musclePercentages' => $exercise->musclePercentages->mapWithKeys(function ($mp) {
                return [$mp->name => $mp->pivot->percentages];
            }),
            'muscleFilters' => $exercise->muscleFilters->pluck('name'),
            'minWeightMale' => $exercise->min_weight_male,
            'maxWeightMale' => $exercise->max_weight_male,
            'minWeightFemale' => $exercise->min_weight_female,
            'maxWeightFemale' => $exercise->max_weight_female,
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
