<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'workouts'; // Указываем имя таблицы
    protected $fillable = [
        'user_id',
        'date',
        'total_experience',
        'exercises_count',
        'total_workout_time',
    ];

    // Каст типов данных
    protected $casts = [
        'date' => 'datetime',
        'total_experience' => 'float',
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с упражнениями в тренировке
    public function exercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_id');
    }
}
