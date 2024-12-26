<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutExercise extends Model
{
    protected $table = 'workout_exercises'; // Указываем имя таблицы
    protected $fillable = [
        'workout_id',
        'exercise_id',
        'sets_count',
    ];

    // Связь с тренировкой
    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    // Связь с упражнением
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    // Связь с сетами
    public function sets()
    {
        return $this->hasMany(ExerciseSet::class, 'workout_exercise_id');
    }
}
