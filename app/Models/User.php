<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    // Связи многие ко многим с мышцами
    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'user_muscle_experience')
            ->withPivot('experience') // Опыт в тренировках мышц
            ->withTimestamps();
    }

    // Связь многие ко многим с упражнениями
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'user_exercise_experience')
            ->withPivot('experience') // Опыт в выполнении упражнений
            ->withTimestamps();
    }

    // Связь многие ко многим с достижениями
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withTimestamps();
    }

    // Дополнительная связь: тренировки
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    // Связь с пользовательскими данными (например, настройки или профили)
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
