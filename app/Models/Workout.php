<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Workout extends Model
{
    protected $collection = 'workouts'; // Укажите имя коллекции MongoDB
    protected $fillable = [
        'userId',
        'date',
        'exercises',
        'totalXP',
        'exercisesCount',
        'totalWorkoutTime',
    ];

    // Атрибуты с вложенными структурами
    protected $casts = [
        'date' => 'datetime',
        'exercises' => 'array', // Указываем, что поле exercises является массивом
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class, '_id', 'userId');
    }
}
