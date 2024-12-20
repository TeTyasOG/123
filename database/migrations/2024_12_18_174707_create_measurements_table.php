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
        Schema::connection('mongodb')->create('measurements', function ($collection) {
            $collection->index('_id'); // MongoDB автоматически создает _id
            $collection->string('userId'); // ID пользователя, совершившего замер
            $collection->date('date'); // Дата замера
            $collection->json('measurements')->nullable(); // Вложенный объект для хранения замеров
            $collection->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('measurements');
    }
};
