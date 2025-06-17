<?php

namespace Database\Factories;

use App\Enums\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->optional()->paragraph(),
            'priority' => fake()->randomElement(TaskPriorityEnum::values()),
            'due_date' => fake()->optional()->date(),
            'is_completed' => fake()->boolean(50),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
