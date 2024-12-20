<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Указываем коллекцию MongoDB
    protected $connection = 'mongodb';
    protected $collection = 'users';

    // Указываем заполняемые поля
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'gender',
        'weight',
        'experience',
        'achievements',
        'muscleExperience',
        'exerciseExperience',
    ];

    // Указываем типы полей
    protected $casts = [
        'gender' => 'string',
        'weight' => 'float',
        'experience' => 'integer',
        'achievements' => 'array', // Массив достижений
        'muscleExperience' => 'array', // Ассоциативный массив
        'exerciseExperience' => 'array', // Ассоциативный массив
    ];

    // Поля с значениями по умолчанию
    protected $attributes = [
        'experience' => 0,
        'achievements' => [],
        'muscleExperience' => [],
        'exerciseExperience' => [],
    ];
}
