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
        Schema::connection('mongodb')->create('users', function ($collection) {
            $collection->index('_id'); // MongoDB автоматически создает _id
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('users');
    }
};
