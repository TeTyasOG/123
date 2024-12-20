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
        Schema::connection('mongodb')->create('exercises', function ($collection) {
            $collection->index('_id'); // MongoDB автоматически создает _id
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('exercises');
    }
};
