<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Program extends Model
{
    // Указываем коллекцию (опционально, если имя коллекции отличается от имени модели в нижнем регистре с окончанием "s")
    protected $collection = 'programs';

    // Определяем атрибуты, которые можно массово заполнять
    protected $fillable = [
        'userId',
        'name',
        'exercises',
    ];

    // Указываем типы данных для атрибутов
    protected $casts = [
        'userId' => 'string', // ObjectId в MongoDB можно хранить как строку
        'exercises' => 'array', // Массив для вложенных данных
    ];

    // Определяем связи
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', '_id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'exerciseId', '_id');
    }
}
