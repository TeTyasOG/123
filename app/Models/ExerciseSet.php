<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseSet extends Model
{
    protected $table = 'exercise_sets'; // Указываем имя таблицы
    protected $fillable = [
        'workout_exercise_id',
        'weight',
        'reps',
        'rpe',
    ];

    // Связь с упражнением в тренировке
    public function workoutExercise()
    {
        return $this->belongsTo(WorkoutExercise::class);
    }
}
