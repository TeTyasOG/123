<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Measurement extends Model
{
    // Указываем коллекцию MongoDB (по умолчанию используется имя модели в нижнем регистре с добавлением 's')
    protected $collection = 'measurements';

    // Указываем, что модель будет использовать MongoDB
    protected $connection = 'mongodb';

    // Поля, которые могут быть заполнены
    protected $fillable = [
        'userId',
        'date',
        'measurements',
    ];

    // Типы данных для атрибутов
    protected $casts = [
        'date' => 'datetime',
        'measurements' => 'array',
    ];

    // Указываем связь с моделью User (если такая модель есть)
    public function user()
    {
        return $this->belongsTo(User::class, '_id', 'userId');
    }
}
