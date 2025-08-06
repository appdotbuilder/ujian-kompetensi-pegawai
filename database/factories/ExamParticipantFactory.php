<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ExamParticipant;
use App\Models\ExamRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamParticipant>
 */
class ExamParticipantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\ExamParticipant>
     */
    protected $model = ExamParticipant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'exam_room_id' => ExamRoom::factory(),
            'participant_number' => 'P' . str_pad((string)$this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'employee_id' => 'EMP' . $this->faker->unique()->numberBetween(1000, 9999),
            'status' => 'registered',
            'is_present' => false,
        ];
    }

    /**
     * Indicate that the participant is present.
     */
    public function present(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_present' => true,
            'status' => 'present',
            'check_in_time' => $this->faker->dateTimeThisMonth(),
        ]);
    }

    /**
     * Indicate that the participant has completed the exam.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_present' => true,
            'status' => 'completed',
            'check_in_time' => $this->faker->dateTimeThisMonth(),
        ]);
    }
}