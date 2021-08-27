<?php

namespace Database\Factories;

use App\Models\SeedTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeedTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SeedTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'level' => $this->faker->numberBetween(0, 30),
        ];
    }
}
