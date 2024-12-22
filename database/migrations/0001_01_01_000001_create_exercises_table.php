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
        Schema::create('muscles_percentages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название мышцы
            $table->timestamps();
        });

        // Таблица фильтров мышц
        Schema::create('muscles_filters', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название фильтра
            $table->timestamps();
        });

        // Промежуточная таблица для связи упражнений и мышц (нагрузка)
        Schema::create('exercises_muscles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercises_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('muscles_percentages_id')->constrained('muscles_percentages')->onDelete('cascade');
            $table->integer('percentages')->nullable(); // Нагрузка на мышцу в процентах
            $table->timestamps();
        });

        // Промежуточная таблица для связи упражнений и фильтров мышц
        Schema::create('exercises_muscles_filter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercises_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('muscles_filter_id')->constrained('muscles_filters')->onDelete('cascade');
            $table->timestamps();
        });

        // Таблица советов
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->string('content'); // Текст совета
            $table->timestamps();
        });

        // Промежуточная таблица для связи упражнений и советов
        Schema::create('exercises_tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercises_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('tips_id')->constrained('tips')->onDelete('cascade');
            $table->timestamps();
        });

        // Наполнение таблицы мышц (нагрузка)
        $this->seedMusclesPercentages();

        // Наполнение таблицы фильтров мышц
        $this->seedMusclesFilters();
    }

    /**
     * Наполнение таблицы мышц
     */
    protected function seedMusclesPercentages()
    {
        $muscles_percentages = ['Грудь', 'Спина', 'Пресс', 'Ноги', 'Плечи', 'Руки'];

        foreach ($muscles_percentages as $muscles) {
            \DB::table('muscles_percentages')->insert(['name' => $muscles, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Наполнение таблицы фильтров мышц
     */
    protected function seedMusclesFilters()
    {
        $filters = [
            'Грудь', 'Верхняя часть спины', 'Пресс', 'Икры', 'Квадрицепс',
            'Нижняя часть спины', 'Плечи', 'Подколенные сухожилия',
            'Предплечья', 'Трапеции', 'Трицепс', 'Широчайшие',
            'Ягодицы', 'Бицепс'
        ];

        foreach ($filters as $filter) {
            \DB::table('muscles_filters')->insert(['name' => $filter, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises_tips');
        Schema::dropIfExists('tips');
        Schema::dropIfExists('exercises_muscles_filter');
        Schema::dropIfExists('muscles_filters');
        Schema::dropIfExists('exercises_muscles');
        Schema::dropIfExists('muscles_percentages');
        Schema::dropIfExists('exercises');
    }
};
