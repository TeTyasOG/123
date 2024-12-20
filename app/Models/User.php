<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Указываем коллекцию, если она не совпадает с названием модели
    protected $collection = 'users'; 

    // Указываем заполняемые поля
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'age',
        'gender',
        'height',
        'weight',
        'experience',
        'level',
        'achievements',
        'muscleExperience',
        'muscleLevels',
        'exerciseExperience',
        'exerciseLevels',
    ];

    // Указываем типы полей
    protected $casts = [
        'age' => 'integer',
        'height' => 'integer',
        'weight' => 'integer',
        'experience' => 'integer',
        'level' => 'integer',
        'achievements' => 'array', // Массив строк
        'muscleExperience' => 'array', // Ассоциативный массив
        'muscleLevels' => 'array', // Ассоциативный массив
        'exerciseExperience' => 'array', // Объект
        'exerciseLevels' => 'array', // Объект
    ];

    // Поля с значениями по умолчанию
    protected $attributes = [
        'experience' => 0,
        'level' => 1,
        'muscleExperience' => [],
        'muscleLevels' => [],
        'exerciseExperience' => [],
        'exerciseLevels' => [],
    ];
}
