<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => rtrim(fake()->sentence(rand(5, 10)), '.'),
            'body' => fake()->paragraphs(rand(3, 7), true),
            'views' => fake()->numberBetween(0, 10),
            'answers' => fake()->numberBetween(0, 10),
            'votes' => fake()->numberBetween(-3, 10),
        ];
    }
}
