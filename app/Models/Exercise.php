<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    // Укажите заполняемые поля
    protected $fillable = [
        'name',
        'video_url',
        'thumbnail_url',
        'min_weight_male',
        'max_weight_male',
        'min_weight_female',
        'max_weight_female',
        'description',
    ];

    // Укажите типы данных, если необходимо
    protected $casts = [
        'min_weight_male' => 'float',
        'max_weight_male' => 'float',
        'min_weight_female' => 'float',
        'max_weight_female' => 'float',
    ];

    /**
     * Связь с мышцами через процент нагрузки.
     */
    public function muscles()
    {
        return $this->belongsToMany(
            MusclePercentage::class,
            'exercises_muscles',
            'exercises_id',
            'muscles_percentages_id'
        )->withPivot('percentages')->withTimestamps();
    }

    /**
     * Связь с фильтрами мышц.
     */
    public function muscleFilters()
    {
        return $this->belongsToMany(
            MuscleFilter::class,
            'exercises_muscles_filter',
            'exercises_id',
            'muscles_filter_id'
        )->withTimestamps();
    }

    /**
     * Связь с советами.
     */
    public function tips()
    {
        return $this->belongsToMany(
            Tip::class,
            'exercises_tips',
            'exercises_id',
            'tips_id'
        )->withTimestamps();
    }

    public function users()
{
    return $this->belongsToMany(
        User::class,
        'user_exercise_experience',
        'exercise_id',
        'user_id'
    )->withPivot('experience')->withTimestamps();
}
// Связь с тренировочными упражнениями
public function workoutExercises()
{
    return $this->hasMany(WorkoutExercise::class);
}

}
