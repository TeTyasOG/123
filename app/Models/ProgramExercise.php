<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramExercise extends Model
{
    // Указываем таблицу, с которой работает модель
    protected $table = 'program_exercises';

    // Атрибуты, которые можно массово заполнять
    protected $fillable = [
        'program_id',
        'exercise_id',
        'sets',
        'weight',
        'reps',
    ];

    // Указываем типы данных для атрибутов
    protected $casts = [
        'program_id' => 'integer',
        'exercise_id' => 'integer',
        'sets' => 'integer',
        'weight' => 'float',
        'reps' => 'integer',
    ];

    // Определяем связи

    /**
     * Связь "Принадлежит программе"
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Связь "Принадлежит упражнению"
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
