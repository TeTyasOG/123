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
        // Таблица программ
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Связь с пользователем
            $table->string('name'); // Название программы
            $table->timestamps();
        });

        // Промежуточная таблица для связи программ и упражнений
        Schema::create('program_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade'); // Связь с программой
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade'); // Связь с упражнением
            $table->integer('sets'); // Количество сетов
            $table->float('weight'); // Вес в сете
            $table->integer('reps'); // Количество повторений
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
        Schema::dropIfExists('program_exercises');
        Schema::dropIfExists('programs');
    }
};
