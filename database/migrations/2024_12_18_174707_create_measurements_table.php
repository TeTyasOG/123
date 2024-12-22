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
        // Таблица замеров
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Связь с пользователем
            $table->date('date'); // Дата замера
            $table->timestamps();
        });

        // Таблица единиц замеров
        Schema::create('unit_measurements', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название единицы замера
            $table->timestamps();
        });

        // Промежуточная таблица для связи замеров и их частей
        Schema::create('measurement_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measurement_id')->constrained('measurements')->onDelete('cascade'); // Связь с замером
            $table->foreignId('unit_measurement_id')->constrained('unit_measurements')->onDelete('cascade'); // Связь с частью замера
            $table->float('value')->nullable(); // Значение замера
            $table->timestamps();
        });

        // Наполнение таблицы единиц замеров начальными значениями
        $this->seedUnitMeasurements();
    }

    /**
     * Наполнение таблицы единиц замеров начальными значениями.
     */
    protected function seedUnitMeasurements()
    {
        $units = [
            'Масса тела (кг)', 'Талия (см)', 'Содержание жира (%)', 'Шея (см)', 'Плечи',
            'Грудь (см)', 'Левый бицепс (см)', 'Правый бицепс (см)', 'Левое предплечье (см)',
            'Правое предплечье (см)', 'Живот (см)', 'Ягодицы (см)', 'Левое бедро (см)',
            'Правое бедро (см)', 'Левая икра (см)', 'Правая икра (см)'
        ];

        foreach ($units as $unit) {
            \DB::table('unit_measurements')->insert(['name' => $unit, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurement_unit');
        Schema::dropIfExists('unit_measurements');
        Schema::dropIfExists('measurements');
    }
};
