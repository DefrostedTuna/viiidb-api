<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'position' => $faker->unique()->randomNumber,
        'name' => $faker->name,
        'type' => $faker->word,
        'description' => $faker->paragraph,
        'menu_effect' => $faker->sentence,
        'price' => $faker->numberBetween(1, 50000),
        'value' => $faker->numberBetween(1, 50000),
        'haggle' => $faker->numberBetween(1, 50000),
        'sell_high' => $faker->numberBetween(1, 50000),
        'used_in_menu' => $faker->boolean,
        'used_in_battle' => $faker->boolean,
        'notes' => $faker->sentence,
    ];
});
