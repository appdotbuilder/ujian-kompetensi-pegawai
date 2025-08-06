<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ExamRoom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamRoom>
 */
class ExamRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\ExamRoom>
     */
    protected $model = ExamRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'name' => 'Ruang ' . $this->faker->randomLetter(),
            'capacity' => $this->faker->numberBetween(20, 50),
            'location' => $this->faker->sentence(3),
        ];
    }
}