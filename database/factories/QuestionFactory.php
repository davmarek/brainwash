<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Types\CallableParameter;

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
            'question_text' => fake('cs_CZ')->realText(100),
            'is_open_question' => false,
        ];
    }

    public function is_open_question() : Factory
    {
        return $this->state(function (array $attributes){
            return [
                'is_open_question' => true,
            ];
        });
    }
}
