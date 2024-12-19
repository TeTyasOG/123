<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Создание коллекции для пользователей
        Schema::connection('mongodb')->create('users', function (Blueprint $collection) {
            $collection->index('nickname');
            $collection->index('email');
        });

        // Создание коллекции для упражнений
        Schema::connection('mongodb')->create('exercises', function (Blueprint $collection) {
            $collection->index('name');
            $collection->index('englishName');
        });

        // Создание коллекции для измерений
        Schema::connection('mongodb')->create('measurements', function (Blueprint $collection) {
            $collection->index('userId');
            $collection->index('date');
        });

        // Создание коллекции для программ
        Schema::connection('mongodb')->create('programs', function (Blueprint $collection) {
            $collection->index('userId');
            $collection->index('name');
        });

        // Создание коллекции для тренировок
        Schema::connection('mongodb')->create('workouts', function (Blueprint $collection) {
            $collection->index('userId');
            $collection->index('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->drop('users');
        Schema::connection('mongodb')->drop('exercises');
        Schema::connection('mongodb')->drop('measurements');
        Schema::connection('mongodb')->drop('programs');
        Schema::connection('mongodb')->drop('workouts');
    }
}
