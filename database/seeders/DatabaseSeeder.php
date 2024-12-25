<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Вызов только сидера для упражнений
        $this->call([
            ExerciseSeeder::class,
        ]);
    }
}
