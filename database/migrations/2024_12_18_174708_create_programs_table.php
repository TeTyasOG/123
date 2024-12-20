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
        Schema::connection('mongodb')->create('programs', function ($collection) {
            $collection->index('_id'); // MongoDB автоматически создает _id
            $collection->string('userId'); // ID пользователя, которому принадлежит программа
            $collection->string('name'); // Название программы
            $collection->array('exercises')->nullable(); // Массив с упражнениями
            $collection->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('programs');
    }
};
