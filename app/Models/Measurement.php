<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    // Таблица, связанная с моделью
    protected $table = 'measurements';

    // Поля, которые могут быть заполнены
    protected $fillable = [
        'user_id',
        'date',
    ];

    // Типы данных для атрибутов
    protected $casts = [
        'date' => 'date',
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Связь с промежуточной таблицей (measurement_unit)
    public function measurementUnits()
    {
        return $this->hasMany(MeasurementUnit::class, 'measurement_id');
    }
}
