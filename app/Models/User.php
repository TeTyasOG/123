<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Указываем таблицу
    protected $table = 'users';

    // Заполняемые поля
    protected $fillable = [
        'nickname',
        'email',
        'password',
        'gender',
        'weight',
        'experience',
    ];

    // Типы данных для атрибутов
    protected $casts = [
        'email_verified_at' => 'datetime',
        'weight' => 'float',
        'experience' => 'float',
    ];

    // Скрываемые поля (например, пароль)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Связи многие ко многим
    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'user_muscle_experience')
        ->withPivot('experience')
        ->withTimestamps();
    }

    public function exercises()
    {
    return $this->belongsToMany(Exercise::class, 'user_exercise_experience')
        ->withPivot('experience')
        ->withTimestamps();
    }

    public function achievements()
    {

        return $this->belongsToMany(Achievement::class, 'user_achievements')
        ->withTimestamps();
    }
}
