<?php

namespace Database\Factories;

use App\Models\StatusEffect;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->word,
            'description' => $this->faker->paragraph,
        ];
    }
}
