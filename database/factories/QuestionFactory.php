<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Question>
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['multiple_choice', 'true_false']);
        $options = null;
        $correctAnswer = 'A';

        if ($type === 'multiple_choice') {
            $options = [
                'A' => $this->faker->sentence(),
                'B' => $this->faker->sentence(),
                'C' => $this->faker->sentence(),
                'D' => $this->faker->sentence(),
            ];
            $correctAnswer = $this->faker->randomElement(['A', 'B', 'C', 'D']);
        } else {
            $correctAnswer = $this->faker->randomElement(['true', 'false']);
        }

        return [
            'exam_id' => Exam::factory(),
            'question_text' => $this->faker->paragraph() . '?',
            'question_type' => $type,
            'options' => $options,
            'correct_answer' => $correctAnswer,
            'points' => $this->faker->numberBetween(1, 5),
            'order_index' => 0,
        ];
    }

    /**
     * Indicate that this is a true/false question.
     */
    public function trueFalse(): static
    {
        return $this->state(fn (array $attributes) => [
            'question_type' => 'true_false',
            'options' => null,
            'correct_answer' => $this->faker->randomElement(['true', 'false']),
        ]);
    }

    /**
     * Indicate that this is a multiple choice question.
     */
    public function multipleChoice(): static
    {
        $options = [
            'A' => $this->faker->sentence(),
            'B' => $this->faker->sentence(),
            'C' => $this->faker->sentence(),
            'D' => $this->faker->sentence(),
        ];

        return $this->state(fn (array $attributes) => [
            'question_type' => 'multiple_choice',
            'options' => $options,
            'correct_answer' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
        ]);
    }
}