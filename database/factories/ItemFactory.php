<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'position' => $this->faker->unique()->randomNumber,
            'name' => $this->faker->name,
            'type' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'menu_effect' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1, 50000),
            'value' => $this->faker->numberBetween(1, 50000),
            'haggle' => $this->faker->numberBetween(1, 50000),
            'sell_high' => $this->faker->numberBetween(1, 50000),
            'used_in_menu' => $this->faker->boolean,
            'used_in_battle' => $this->faker->boolean,
            'notes' => $this->faker->sentence,
        ];
    }
}
