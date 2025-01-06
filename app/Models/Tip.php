<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    protected $fillable = ['content'];
    protected $table = 'tips'; // Укажите имя таблицы
}
