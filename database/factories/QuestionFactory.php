<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
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
            'question_text' => fake('cs_CZ')->sentence(),
            'is_open_question' => false,
            'open_answer' => null,
        ];
    }

    public function is_open_question(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_open_question' => true,
                'open_answer' => fake()->sentence(),
            ];
        });
    }
}
