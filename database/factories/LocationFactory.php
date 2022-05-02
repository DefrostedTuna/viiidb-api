<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'region_id' => null,
            'parent_id' => null,
            'sort_id' => $this->faker->unique()->numberBetween(1, 500),
            'slug' => $this->faker->slug,
            'name' => $this->faker->words(3, true),
            'notes' => $this->faker->sentence,
        ];
    }
}
