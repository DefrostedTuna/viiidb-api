<?php

namespace Database\Factories;

use App\Models\SeedRank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SeedRank>
 */
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
        $seedRanks = ['1', '2', '3', '4', '5', '6', '7', '8', '9', 'A'];

        return [
            'rank' => $this->faker->randomElement($seedRanks),
            'salary' => $this->faker->numberBetween(500, 30000),
        ];
    }
}
