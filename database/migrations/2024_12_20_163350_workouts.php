<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('workouts', function ($collection) {
            $collection->index('_id'); // MongoDB автоматически создает _id
            $collection->string('userId'); // ID пользователя, совершившего тренировку
            $collection->date('date'); // Дата тренировки
            $collection->array('exercises')->nullable(); // Массив упражнений
            $collection->integer('totalXP')->nullable(); // Общее количество опыта
            $collection->integer('exercisesCount')->nullable(); // Количество выполненных упражнений
            $collection->integer('totalWorkoutTime')->nullable(); // Общее время тренировки в минутах
            $collection->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('workouts');
    }
};
