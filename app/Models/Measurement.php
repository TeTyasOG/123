<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Measurement extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'measurements';

    protected $fillable = [
        'userId',
        'date',
        'measurements',
    ];

    protected $casts = [
        'measurements' => 'array', // Преобразуем поле measurements в массив
        'date' => 'datetime'
    ];
}
