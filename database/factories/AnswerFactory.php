<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'answer_text' => fake('cs_CZ')->catchPhrase(),
            'is_correct' => false,
        ];
    }

    public function is_correct() : Factory
    {
        return $this->state(function (array $attributes){
            return [
                'is_correct' => true,
                'answer_text' => 'Correct answer',
            ];
        });
    }
}
