<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModels extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Создание коллекции для пользователей
        Schema::connection('mongodb')->create('users', function (Blueprint $collection) {
            $collection->string('nickname')->unique(); // Уникальный никнейм
            $collection->string('email')->unique(); // Уникальный email
            $collection->string('password'); // Пароль
            $collection->string('gender')->nullable(); // Пол (необязательный)
            $collection->float('weight')->nullable(); // Вес (необязательный)
            $collection->integer('experience')->nullable(); // Опыт пользователя
            $collection->array('achievements')->nullable(); // Массив достижений
            $collection->json('muscleExperience')->nullable(); // Объект с опытом для мышц
            $collection->json('exerciseExperience')->nullable(); // Объект с опытом для упражнений
            $collection->timestamps(); // Поля created_at и updated_at
        });

        // Создание коллекции для упражнений
        Schema::connection('mongodb')->create('exercises', function (Blueprint $collection) {
            $collection->string('name'); // Название упражнения
            $collection->string('englishName'); // Английское название упражнения
            $collection->string('videoUrl')->nullable(); // URL видео
            $collection->string('thumbnailUrl')->nullable(); // URL изображения
            $collection->json('musclePercentages')->nullable(); // Объект с распределением нагрузки
            $collection->array('muscleFilter')->nullable(); // Список вовлеченных мышц
            $collection->integer('minWeightMale')->nullable(); // Минимальный вес для мужчин
            $collection->integer('maxWeightMale')->nullable(); // Максимальный вес для мужчин
            $collection->integer('minWeightFemale')->nullable(); // Минимальный вес для женщин
            $collection->integer('maxWeightFemale')->nullable(); // Максимальный вес для женщин
            $collection->text('description')->nullable(); // Описание упражнения
            $collection->array('tips')->nullable(); // Советы по выполнению упражнения
            $collection->timestamps(); // Поля created_at и updated_at
        });

        // Создание коллекции для измерений
        Schema::connection('mongodb')->create('measurements', function (Blueprint $collection) {
            $collection->string('userId'); // ID пользователя, совершившего замер
            $collection->date('date'); // Дата замера
            $collection->json('measurements')->nullable(); // Вложенный объект для хранения замеров
            $collection->timestamps(); // Поля created_at и updated_at
        });

        // Создание коллекции для программ
        Schema::connection('mongodb')->create('programs', function (Blueprint $collection) {
            $collection->string('userId'); // ID пользователя, которому принадлежит программа
            $collection->string('name'); // Название программы
            $collection->array('exercises')->nullable(); // Массив с упражнениями
            $collection->timestamps(); // Поля created_at и updated_at
        });

        // Создание коллекции для тренировок
        Schema::connection('mongodb')->create('workouts', function (Blueprint $collection) {
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
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('users');
        Schema::connection('mongodb')->dropIfExists('exercises');
        Schema::connection('mongodb')->dropIfExists('measurements');
        Schema::connection('mongodb')->dropIfExists('programs');
        Schema::connection('mongodb')->dropIfExists('workouts');
    }
}
