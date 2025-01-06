<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
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

    protected $casts = [
        'min_weight_male'   => 'float',
        'max_weight_male'   => 'float',
        'min_weight_female' => 'float',
        'max_weight_female' => 'float',
    ];

    /**
     * Связь с моделью MusclePercentage (через таблицу exercises_muscles).
     * Возвращает коллекцию мышц с pivot-полем 'percentages'.
     */
    public function musclePercentages()
    {
        return $this->belongsToMany(
            MusclePercentage::class,
            'exercises_muscles',
            'exercises_id',
            'muscles_percentages_id'
        )->withPivot('percentages')->withTimestamps();
    }

    /**
     * Связь с моделью MuscleFilter (через таблицу exercises_muscles_filter).
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

    /**
     * Связь с пользователями (пример, если есть user_exercise_experience).
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_exercise_experience',
            'exercise_id',
            'user_id'
        )->withPivot('experience')->withTimestamps();
    }

    /**
     * Связь с тренировочными упражнениями (если реализовано через модель WorkoutExercise).
     */
    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class);
    }
}
