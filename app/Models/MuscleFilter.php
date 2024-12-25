<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuscleFilter extends Model
{
    protected $table = 'muscles_filters';

    protected $fillable = ['name'];

    public function exercises()
    {
        return $this->belongsToMany(
            Exercise::class,
            'exercises_muscles_filter',
            'muscles_filter_id',
            'exercises_id'
        )->withTimestamps();
    }
}
