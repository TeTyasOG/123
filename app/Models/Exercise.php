<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Exercise extends Model
{
    protected $connection = 'mongodb'; // указываем, что это подключение к MongoDB
    protected $collection = 'exercises'; // имя коллекции, если отличается от 'exercises', укажите нужное

    // Модель не знает о схемах как Mongoose, поэтому просто указываем поля, которые можно массово присваивать.
    protected $fillable = [
        'name',
        'englishName',
        'videoUrl',
        'thumbnailUrl',
        // musclePercentages будет храниться как объект/массив
        // В Laravel Map типа не нужно особо указывать, просто хранится как массив или объект
        'musclePercentages', 
        'muscleFilter',
        'minWeightMale',
        'maxWeightMale',
        'minWeightFemale',
        'maxWeightFemale',
        'description',
        'tips'
    ];

    // Если нужно, можно добавить касты типов:
    protected $casts = [
        'musclePercentages' => 'array', // Сохраняем Map как массив
        'muscleFilter' => 'array',
        'tips' => 'array'
    ];
}
