<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muscle extends Model
{
    use HasFactory;

    protected $table = 'muscles'; // Указываем таблицу

    protected $fillable = ['name']; // Поля, которые можно заполнять

    /**
     * Связь с пользователями через таблицу user_muscles_experience.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_muscles_experience')
            ->withPivot('experience') // Поле 'experience' в промежуточной таблице
            ->withTimestamps();
    }
}
