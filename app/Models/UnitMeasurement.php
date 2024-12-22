<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMeasurement extends Model
{
    use HasFactory;

    // Таблица, связанная с моделью
    protected $table = 'unit_measurements';

    // Поля, которые могут быть заполнены
    protected $fillable = [
        'name',
    ];

    // Связь с промежуточной таблицей
    public function measurementUnits()
    {
        return $this->hasMany(MeasurementUnit::class, 'unit_measurement_id');
    }
}
