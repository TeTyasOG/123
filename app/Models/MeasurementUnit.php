<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    use HasFactory;

    // Таблица, связанная с моделью
    protected $table = 'measurement_unit';

    // Поля, которые могут быть заполнены
    protected $fillable = [
        'measurement_id',
        'unit_measurement_id',
        'value',
    ];

    // Связь с замером
    public function measurement()
    {
        return $this->belongsTo(Measurement::class, 'measurement_id');
    }

    // Связь с единицей измерения
    public function unitMeasurement()
    {
        return $this->belongsTo(UnitMeasurement::class, 'unit_measurement_id');
    }
}
