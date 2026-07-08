<?php

namespace Database\Factories;

use App\Models\WorkoutLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkoutLog>
 */
class WorkoutLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'workout_date' => fake()->date(),
            'workout_type' => fake()->randomElement(['Lari', 'Jalan Cepat', 'Bersepeda', 'Berenang', 'Lainnya']),
            'duration' => fake()->numberBetween(15, 120),
            'distance' => fake()->randomFloat(2, 1, 25),
            'notes' => fake()->sentence(),
        ];
    }
}
