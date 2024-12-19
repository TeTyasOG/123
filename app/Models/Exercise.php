<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Exercise extends Model
{

    // Укажите используемое подключение (mongodb)
    protected $connection = 'mongodb';

    // Укажите заполняемые поля
    protected $fillable = [
        'name',
        'englishName',
        'videoUrl',
        'thumbnailUrl',
        'musclePercentages',
        'muscleFilter',
        'minWeightMale',
        'maxWeightMale',
        'minWeightFemale',
        'maxWeightFemale',
        'description',
        'tips',
    ];

    // Укажите типы данных, если необходимо
    protected $casts = [
        'musclePercentages' => 'array',
        'muscleFilter' => 'array',
        'tips' => 'array',
        'minWeightMale' => 'float',
        'maxWeightMale' => 'float',
        'minWeightFemale' => 'float',
        'maxWeightFemale' => 'float',
    ];
}
