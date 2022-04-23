<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
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
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->slug,
            'position' => $this->faker->unique()->numberBetween(1, 198),
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement([
                'Medicine',
                'Tool',
                'GF Medicine',
                'Ammo',
                'Miscellaneous',
                'Magazine',
            ]),
            'description' => $this->faker->sentence,
            'menu_effect' => $this->faker->sentence,
            'value' => $this->faker->numberBetween(1, 100000),
            'price' => $this->faker->numberBetween(1, 100000),
            'sell_high' => $this->faker->numberBetween(1, 100000),
            'haggle' => $this->faker->numberBetween(1, 100000),
            'used_in_menu' => $this->faker->boolean(50),
            'used_in_battle' => $this->faker->boolean(50),
            'notes' => $this->faker->sentence,
        ];
    }
}
