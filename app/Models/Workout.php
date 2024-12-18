<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Workout extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'workouts';

    protected $fillable = [
        'userId',
        'date',
        'exercises',
        'totalXP',
        'exercisesCount',
        'totalWorkoutTime'
    ];

    protected $casts = [
        // exercises — массив объектов { exerciseId, sets: [{weight, reps, rpe}], notes: string }
        'exercises' => 'array',
        'date' => 'datetime',
        'totalXP' => 'integer',
        'exercisesCount' => 'integer'
    ];
}
