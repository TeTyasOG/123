<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Program extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'programs';

    protected $fillable = [
        'userId',
        'name',
        'exercises'
    ];

    protected $casts = [
        // exercises это массив объектов { exerciseId, sets, reps }
        'exercises' => 'array',
    ];
}
