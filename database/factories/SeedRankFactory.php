<?php

namespace Database\Factories;

use App\Models\SeedRank;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeedRankFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SeedRank::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'rank' => $this->faker->numberBetween(1, 30),
            'salary' => $this->faker->numberBetween(500, 30000),
        ];
    }
}
