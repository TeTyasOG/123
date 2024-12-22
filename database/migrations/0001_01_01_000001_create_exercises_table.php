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
        // Таблица упражнений
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название упражнения
            $table->string('video_url')->nullable(); // Видео упражнения
            $table->string('thumbnail_url')->nullable(); // Превью упражнения
            $table->integer('min_weight_male')->nullable(); // Минимальный вес для мужчин
            $table->integer('max_weight_male')->nullable(); // Максимальный вес для мужчин
            $table->integer('min_weight_female')->nullable(); // Минимальный вес для женщин
            $table->integer('max_weight_female')->nullable(); // Максимальный вес для женщин
            $table->text('description')->nullable(); // Описание упражнения
            $table->timestamps();
        });

        // Таблица мышц (нагрузка в %)
        Schema::create('muscle_percentages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название мышцы
            $table->timestamps();
        });

        // Таблица фильтров мышц
        Schema::create('muscle_filters', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название фильтра
            $table->timestamps();
        });

        // Промежуточная таблица для связи упражнений и мышц (нагрузка)
        Schema::create('exercise_muscle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('muscle_percentages_id')->constrained('muscle_percentages')->onDelete('cascade');
            $table->integer('percentage')->nullable(); // Нагрузка на мышцу в процентах
            $table->timestamps();
        });

        // Промежуточная таблица для связи упражнений и фильтров мышц
        Schema::create('exercise_muscle_filter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('muscle_filter_id')->constrained('muscle_filters')->onDelete('cascade');
            $table->timestamps();
        });

        // Таблица советов
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->string('content'); // Текст совета
            $table->timestamps();
        });

        // Промежуточная таблица для связи упражнений и советов
        Schema::create('exercise_tip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('tip_id')->constrained('tips')->onDelete('cascade');
            $table->timestamps();
        });

        // Наполнение таблицы мышц (нагрузка)
        $this->seedMusclePercentages();

        // Наполнение таблицы фильтров мышц
        $this->seedMuscleFilters();
    }

    /**
     * Наполнение таблицы мышц
     */
    protected function seedMusclePercentages()
    {
        $muscle_percentages = ['Грудь', 'Спина', 'Пресс', 'Ноги', 'Плечи', 'Руки'];

        foreach ($muscle_percentages as $muscle) {
            \DB::table('muscle_percentages')->insert(['name' => $muscle, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Наполнение таблицы фильтров мышц
     */
    protected function seedMuscleFilters()
    {
        $filters = [
            'Грудь', 'Верхняя часть спины', 'Пресс', 'Икры', 'Квадрицепс',
            'Нижняя часть спины', 'Плечи', 'Подколенные сухожилия',
            'Предплечья', 'Трапеции', 'Трицепс', 'Широчайшие',
            'Ягодицы', 'Бицепс'
        ];

        foreach ($filters as $filter) {
            \DB::table('muscle_filters')->insert(['name' => $filter, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_tip');
        Schema::dropIfExists('tips');
        Schema::dropIfExists('exercise_muscle_filter');
        Schema::dropIfExists('muscle_filters');
        Schema::dropIfExists('exercise_muscle');
        Schema::dropIfExists('muscle_percentages');
        Schema::dropIfExists('exercises');
    }
};
