<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ToDo>
 */
class ToDoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3, true),
            'description' => $this->faker->sentence(6, true),
            'finished_at' => $this->faker->boolean()
                ? $this->faker->dateTimeBetween('-1 year', 'now')
                : null,
        ];
    }

    public function notCompleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'finished_at' => null,
            ];
        });
    }
}
