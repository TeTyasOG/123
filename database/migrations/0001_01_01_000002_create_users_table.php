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
        // Таблица пользователей
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname'); // Никнейм
            $table->string('email')->unique(); // Почта
            $table->timestamp('email_verified_at')->nullable(); // Дата подтверждения почты
            $table->string('password'); // Пароль
            $table->float('weight')->nullable(); // Вес
            $table->string('gender')->nullable(); // Пол (например, 'male', 'female')
            $table->float('experience')->default(0); // Общий опыт
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Таблица мышц
        {
            Schema::create('muscles', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Название мышцы
                $table->timestamps();
            });
        }

        // Промежуточная таблица для связи пользователей и мышц (опыт)
        Schema::create('user_muscle_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('muscle_id')->constrained('muscles')->onDelete('cascade');
            $table->float('experience')->default(0); // Опыт в конкретной мышце
            $table->timestamps();
        });

        // Промежуточная таблица для связи пользователей и упражнений (опыт)
        Schema::create('user_exercise_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->float('experience')->default(0); // Опыт в конкретном упражнении
            $table->timestamps();
        });

        // Таблица достижений
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название достижения
            $table->text('description')->nullable(); // Описание достижения
            $table->timestamps();
        });

        // Промежуточная таблица для связи пользователей и достижений
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('achievement_id')->constrained('achievements')->onDelete('cascade');
            $table->timestamps();
        });

        // Наполнение таблицы мышц начальными значениями (если это новая миграция)
        $this->seedMuscles();
    }

    /**
     * Наполнение таблицы мышц начальными значениями
     */
    protected function seedMuscles()
    {
        $muscles = ['Грудь', 'Спина', 'Пресс', 'Ноги', 'Плечи', 'Руки'];

        foreach ($muscles as $muscles) {
            if (!\DB::table('muscles')->where('name', $muscles)->exists()) {
                \DB::table('muscles')->insert(['name' => $muscles, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('user_exercise_experience');
        Schema::dropIfExists('user_muscle_experience');
        Schema::dropIfExists('users');
        Schema::dropIfExists('muscles');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
