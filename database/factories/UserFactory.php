<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nickname' => $this->faker->unique()->userName, // Уникальный никнейм
            'email' => $this->faker->unique()->safeEmail, // Уникальный email
            'email_verified_at' => now(), // Время подтверждения email
            'password' => static::$password ??= Hash::make('password'), // Хэшированный пароль
            'remember_token' => Str::random(10), // Токен запоминания
            'gender' => $this->faker->randomElement(['male', 'female']), // Пол
            'weight' => $this->faker->randomFloat(1, 50, 120), // Случайный вес (50-120 кг)
            'experience' => $this->faker->randomFloat(1, 0, 10), // Опыт (от 0 до 10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
