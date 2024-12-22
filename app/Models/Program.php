<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    // Указываем таблицу, с которой работает модель
    protected $table = 'programs';

    // Атрибуты, которые можно массово заполнять
    protected $fillable = [
        'user_id',
        'name',
    ];

    // Указываем типы данных для атрибутов
    protected $casts = [
        'user_id' => 'integer',
    ];

    // Определяем связи

    /**
     * Связь "Программа принадлежит пользователю"
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь "Программа имеет многие упражнения"
     */
    public function exercises()
    {
        return $this->belongsToMany(
            Exercise::class,
            'program_exercises', // Промежуточная таблица
            'program_id',        // Внешний ключ на таблицу программ
            'exercise_id'        // Внешний ключ на таблицу упражнений
        )->withPivot(['sets', 'weight', 'reps'])->withTimestamps(); // Атрибуты из промежуточной таблицы
    }
}
