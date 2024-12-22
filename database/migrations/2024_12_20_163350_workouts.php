<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Таблица тренировок
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Связь с пользователем
            $table->date('date'); // Дата тренировки
            $table->float('total_experience')->default(0); // Общее количество опыта
            $table->integer('exercises_count')->default(0); // Количество упражнений
            $table->string('total_workout_time')->nullable(); // Общее время тренировки (в формате 1Ч.23М.24С)
            $table->timestamps();
        });

        // Таблица для связи тренировок и упражнений
        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained('workouts')->onDelete('cascade'); // Связь с тренировкой
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade'); // Связь с упражнением
            $table->integer('sets_count')->default(0); // Количество сетов в упражнении
            $table->timestamps();
        });

        // Таблица для связи упражнений и сетов
        Schema::create('exercise_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_exercise_id')->constrained('workout_exercises')->onDelete('cascade'); // Связь с упражнением в тренировке
            $table->float('weight')->default(0); // Вес в сете
            $table->integer('reps')->default(0); // Количество повторений в сете
            $table->float('rpe')->nullable(); // Мера усилия в сете
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_sets');
        Schema::dropIfExists('workout_exercises');
        Schema::dropIfExists('workouts');
    }
};
