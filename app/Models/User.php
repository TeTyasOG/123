<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

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
        'exerciseLevels'
    ];

    protected $casts = [
        'achievements' => 'array',
        'muscleExperience' => 'array', 
        'muscleLevels' => 'array', 
        'exerciseExperience' => 'array', 
        'exerciseLevels' => 'array',
        'experience' => 'integer',
        'level' => 'integer',
        'weight' => 'integer',
        'age' => 'integer'
    ];

    // Если потребуется, можно добавить хук для шифрования пароля:
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
