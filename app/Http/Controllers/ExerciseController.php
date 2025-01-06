<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\WorkoutExercise; // Пивот-модель
use App\Models\ExerciseSet;     // Модель для сетов
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Список упражнений с фильтрацией по группе мышц и поиску
     */
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
            $query->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Получаем все упражнения
        $exercises = $query->with(['users' => function ($query) {
            $query->where('user_id', \Auth::id()); // Загружаем только текущего пользователя
        }])->get();
        

        // Преобразуем данные под нужды фронта
        $mapped = $exercises->map(function ($ex) {
            $userPivot = $ex->users->first(); // Получаем pivot для текущего пользователя
            $xp = $userPivot ? $userPivot->pivot->experience : 0;
            $level = $this->calcLevelFromXP($xp);
            $rank = $this->getRankByXP($xp);
        
            return [
                'id' => $ex->id,
                'name' => $ex->name,
                'videoUrl' => $ex->video_url,
                'thumbnailUrl' => $ex->thumbnail_url,
                'description' => $ex->description,
                'musclePercentages' => $ex->musclePercentages->mapWithKeys(function ($mp) {
                    return [$mp->name => $mp->pivot->percentages];
                }),
                'muscleFilters' => $ex->muscleFilters->pluck('name'),
                'userXP' => $xp,
                'userLevel' => $level,
                'userRank' => $rank,
            ];
        });
    

        return response()->json($mapped);
    }

    /**
     * Недавние упражнения (пример старой логики),
     * ограничено 3 упражнениями, ищет по последним тренировкам
     */
/**
 * Получение последних (до 3) упражнений, выполненных пользователем
 * с учётом фильтрации и сортировки.
 *
 * Параметры запроса:
 * - searchQuery (string) — строка поиска по названию упражнения
 * - muscleGroup (string) — название мышечной группы (или 'ВСЕ МЫШЦЫ')
 * - sortType (string) — тип сортировки ('alphabetical' или 'experience' или другой)
 */
public function getRecentExercises(Request $request)
{
    // 1. Определяем пользователя
    $userId = \Auth::id();

    if (!$userId) {
        logger()->warning('[getRecentExercises] Нет авторизованного пользователя');
        return response()->json(['message' => 'Требуется авторизация.'], 401);
    }

    // 2. Считываем параметры фильтра и сортировки
    $searchQuery = $request->query('searchQuery');
    $muscleGroup = $request->query('muscleGroup', 'ВСЕ МЫШЦЫ');
    $sortType    = $request->query('sortType', 'alphabetical'); // «alphabetical», «experience» и т.д.

    // 3. Получаем последние 10 тренировок
    //    Важно: у вас в таблице workouts поле называется user_id
    //    Если оно называется иначе, подкорректируйте
    $workouts = Workout::where('user_id', $userId)
        ->orderBy('date', 'desc')
        ->limit(10)
        ->get();

    // 4. Собираем все ID тренировок, чтобы найти упражнения из workout_exercises
    $workoutIds = $workouts->pluck('id');
    if ($workoutIds->isEmpty()) {
        return response()->json([]);
    }

    // 5. Загружаем «связки» упражнений (WorkoutExercise) + подтягиваем модель Exercise
    //    с её связями muscleFilters и т.д. + подтягиваем pivot user_exercise_experience (через ->with('exercise.users'))
    //    Ниже: 'exercise.muscleFilters', 'exercise.musclePercentages', 'exercise.users'
    //    — это связи из вашей модели Exercise:
    //         muscleFilters(), musclePercentages(), users().
    $workoutExercises = WorkoutExercise::whereIn('workout_id', $workoutIds)
        ->with([
            'exercise.muscleFilters',
            'exercise.musclePercentages',
            'exercise.users' => function ($q) use ($userId) {
                // Сразу подгрузим pivot для конкретного пользователя
                $q->where('user_id', $userId);
            },
        ])
        ->get();

    // 6. Из коллекции $workoutExercises вытащим сами упражнения (Exercise),
    //    уберём дубликаты (unique('exercise_id') или unique(fn($we) => $we->exercise_id)),
    //    но для удобства сначала просто map на ->exercise, а потом unique('id').
    $exerciseCollection = $workoutExercises->map(function ($we) {
        return $we->exercise;
    })->filter(function ($ex) {
        return $ex !== null; // на всякий случай
    });

    // Убираем дубли по id
    $exerciseCollection = $exerciseCollection->unique('id');

    // 7. Фильтрация по названию (searchQuery)
    if ($searchQuery && $searchQuery !== '') {
        $exerciseCollection = $exerciseCollection->filter(function ($ex) use ($searchQuery) {
            return stripos($ex->name, $searchQuery) !== false;
        });
    }

    // 8. Фильтрация по мышечной группе, если muscleGroup != 'ВСЕ МЫШЦЫ'
    if ($muscleGroup && $muscleGroup !== '' && $muscleGroup !== 'ВСЕ МЫШЦЫ') {
        $exerciseCollection = $exerciseCollection->filter(function ($ex) use ($muscleGroup) {
            // Проверяем, есть ли нужная мышца среди muscleFilters
            $filters = $ex->muscleFilters->pluck('name')->map(function($n){ return mb_strtoupper($n); });
            return $filters->contains(mb_strtoupper($muscleGroup));
        });
    }

    // 9. Сортировка
    //    Допустим, "alphabetical" — по имени,
    //             "experience"  — по опыту (pivot->experience) у данного пользователя.
    //    Если нужна сортировка по «level» (с учётом XP), можно вычислять «level» и сортировать по нему.
    if ($sortType === 'alphabetical') {
        $exerciseCollection = $exerciseCollection->sortBy(function ($ex) {
            return mb_strtoupper($ex->name);
        });
    } elseif ($sortType === 'experience') {
        // Сортируем по опыту у данного пользователя (DESC)
        $exerciseCollection = $exerciseCollection->sortByDesc(function ($ex) use ($userId) {
            // Упражнение может быть привязано к нескольким пользователям, но мы подгрузили только одного
            $userPivot = $ex->users->first();
            return $userPivot ? $userPivot->pivot->experience : 0;
        });
    } else {
        // Если вам нужна сортировка по «level», можно сделать так:
        // $exerciseCollection = $exerciseCollection->sortByDesc(function($ex) use ($userId){
        //     $userPivot = $ex->users->first();
        //     $xp = $userPivot ? $userPivot->pivot->experience : 0;
        //     return $this->calcLevelFromXP($xp);
        // });
    }

    // 10. Ограничение в 3 упражнения
    $exerciseCollection = $exerciseCollection->take(3);

    // 11. Преобразуем в удобный формат для фронта
    //     Покажем уровень упражнения (или ранг) — то есть берём XP из pivot
    //     и прогоняем через calcLevelFromXP/ getRankByXP / т.д.
    $mapped = $exerciseCollection->values()->map(function ($ex) use ($userId) {
        // Получаем опыт
        $userPivot = $ex->users->first(); // т.к. подгрузили с where('user_id', $userId)
        $xp = $userPivot ? $userPivot->pivot->experience : 0;

        // Расчитываем «ранг» (бронза/серебро/золото/алмаз) или возвращаем числовой уровень
        $level = $this->calcLevelFromXP($xp);

        return [
            'id'                => $ex->id,
            'name'              => $ex->name,
            'videoUrl'          => $ex->video_url,
            'thumbnailUrl'      => $ex->thumbnail_url,
            'description'       => $ex->description,
            'musclePercentages' => $ex->musclePercentages->mapWithKeys(function ($mp) {
                return [$mp->name => $mp->pivot->percentages];
            }),
            'muscleFilters'     => $ex->muscleFilters->pluck('name'),
            'userXP'            => $xp,
            'userLevel'         => $level, // например, 0..4
            'userRank'          => $this->getRankByXP($xp), // DIAMOND / GOLD / ...
        ];
    });

    return response()->json($mapped);
}

/**
 * Пример функции вычисления «уровня» (0..4) на основе XP (можно расширить под 10 уровней и т.д.)
 */
private function calcLevelFromXP($xp)
{
    if ($xp >= 15000) {
        return 4; // Алмаз
    } elseif ($xp >= 7000) {
        return 3; // Золото
    } elseif ($xp >= 2500) {
        return 2; // Серебро
    } elseif ($xp >= 500) {
        return 1; // Бронза
    }
    return 0; // Нулевой уровень
}

/**
 * Пример функции вычисления «звания» (строка) на основе XP
 */
private function getRankByXP($xp)
{
    if ($xp >= 15000) {
        return 'DIAMOND';
    } elseif ($xp >= 7000) {
        return 'GOLD';
    } elseif ($xp >= 2500) {
        return 'SILVER';
    } elseif ($xp >= 500) {
        return 'BRONZE';
    }
    return 'NONE';
}


    /**
     * Получение полной информации об упражнении (включая «лучшие» показатели)
     */
    public function getExerciseInfo(Request $request)
    {
        $exerciseId = $request->query('id');
        $userId = \Auth::id();


        $exercise = Exercise::find($exerciseId);
        if (!$exercise) {
            logger()->warning('[getExerciseInfo] Exercise not found, id=' . $exerciseId);
            return response()->json(['message' => 'Упражнение не найдено.'], 404);
        }

        $user = User::find($userId);
        if (!$user) {
            logger()->warning('[getExerciseInfo] User not found, id=' . $userId);
            return response()->json(['message' => 'Пользователь не найден.'], 404);
        }
    
        $userExerciseXP = $exercise->users()->where('user_id', $userId)->first()->pivot->experience ?? 0;

        // Рассчитываем ранг на основе опыта
        $rankName = 'НЕТУ';
        if ($userExerciseXP >= 15000) {
            $rankName = 'DIAMOND';
        } elseif ($userExerciseXP >= 7000) {
            $rankName = 'GOLD';
        } elseif ($userExerciseXP >= 2500) {
            $rankName = 'SILVER';
        } elseif ($userExerciseXP >= 500) {
            $rankName = 'BRONZE';
        }
                

        // Значения по умолчанию
        $bestWeight = 0;
        $bestLevel = 0;
        $bestXP = 0;

        /**
         * Теперь берём тренировки пользователя, находим все workout_id,
         * затем ищем пивот-таблицы workout_exercises (где exercise_id = $exerciseId),
         * и подгружаем их с реляцией sets (exerciseSets).
         */
        if ($user && $userId) {
            // Если у вас в таблице workouts поле user_id, оставляем так:
            // Если у вас реально userId — поменяйте на ->where('userId', $userId)
            $workoutIds = Workout::where('user_id', $userId)->pluck('id');

            $pivotRecords = WorkoutExercise::whereIn('workout_id', $workoutIds)
                ->where('exercise_id', $exerciseId)
                // Связь называется sets() в модели WorkoutExercise
                ->with('sets')
                ->get();

            // Подготовим факторы для определения уровня:
            $gender = ($user->gender === 'female') ? 'female' : 'male';
            // Средний вес для расчёта, если у пользователя нет своего веса
            $avgWeight = ($gender === 'female') ? 60 : 70;
            $userWeight = ($user->weight) ? $user->weight : $avgWeight;
            $weightFactor = $userWeight / $avgWeight;

            $minW = ($gender === 'male')
                ? $exercise->min_weight_male
                : $exercise->min_weight_female;
            $maxW = ($gender === 'male')
                ? $exercise->max_weight_male
                : $exercise->max_weight_female;

            // Корректируем минимальный/максимальный вес с учётом веса пользователя
            $adjMinWeight = $minW * $weightFactor;
            $adjMaxWeight = $maxW * $weightFactor;


            // Перебираем все подходы
            foreach ($pivotRecords as $pivot) {
                // $pivot->sets - коллекция подходов
                // (В контроллере ранее было 'exerciseSets', но у вас в модели
                //  WorkoutExercise метод называется sets())
                foreach ($pivot->sets as $set) {
                    $weight = $set->weight;
                    $reps   = $set->reps;
                    $rpe    = $set->rpe;


                    // ЛУЧШИЙ ВЕС
                    if ($weight > $bestWeight) {
                        $bestWeight = $weight;
                    }

                    // ЛУЧШИЙ УРОВЕНЬ
                    $level = $this->calculateWeightLevel($weight, $adjMinWeight, $adjMaxWeight);
                    if ($level > $bestLevel) {
                        $bestLevel = $level;
                    }

                    // ЛУЧШИЙ ОПЫТ
                    if ($reps <= 0) {
                        // Если почему-то 0 или отриц., пропускаем
                        continue;
                    }

                    $rpeBonus = 0;
                    if ($rpe > 5) {
                        $rpeBonus = ($rpe - 5) * 0.05;
                    }

                    // Множитель повторений
                    $multiRepFactor = 1.0;
                    if ($reps >= 13 && $reps <= 15) {
                        $multiRepFactor = 0.8;
                    } elseif ($reps >= 16) {
                        $multiRepFactor = 0.5;
                    }

                    // Формула XP
                    $currentXP = ($level * $reps) * (1 + $rpeBonus) * $multiRepFactor;

                    if ($currentXP > $bestXP) {
                        // Округлим до десятых (или оставим без округления)
                        $bestXP = round($currentXP, 1);
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
            // Предположим, что tips - это BelongsToMany (как у вас в модели)
            'tips' => $exercise->tips,
            'userExerciseXP' => $userExerciseXP,
            'bestWeight' => $bestWeight,
            'bestWeightLevel' => $bestLevel,
            'bestXP' => $bestXP
        ]);
    }

    /**
     * Расчёт уровня (Level) в диапазоне [1..10] в зависимости от веса
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
        $level = ($ratio * 9) + 1;
        return round($level); // округляем до ближайшего целого
    }
}
