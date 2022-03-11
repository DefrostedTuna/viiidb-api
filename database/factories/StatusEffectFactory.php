<?php

namespace Database\Factories;

use App\Models\StatusEffect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StatusEffect>
 */
class StatusEffectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StatusEffect::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sort_id' => $this->faker->unique()->numberBetween(1, 28),
            'name' => $this->faker->word,
            'type' => $this->faker->word,
            'description' => $this->faker->paragraph,
        ];
    }
}
