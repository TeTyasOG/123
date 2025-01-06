<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusclePercentage extends Model
{
    protected $table = 'muscles_percentages';

    protected $fillable = ['name'];

    public function exercises()
    {
        return $this->belongsToMany(
            Exercise::class,
            'exercises_muscles',
            'muscles_percentages_id',
            'exercises_id'
        )->withPivot('percentages')->withTimestamps();
    }
}
