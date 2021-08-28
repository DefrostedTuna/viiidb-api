<?php

namespace Database\Factories;

use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'seed_test_id' => null,
            'sort_id' => $this->faker->unique()->numberBetween(1, 300),
            'question_number' => $this->faker->numberBetween(1, 10),
            'question' => $this->faker->paragraph,
            'answer' => $this->faker->boolean(50),
        ];
    }
}
