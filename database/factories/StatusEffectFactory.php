<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StatusEffect;
use Faker\Generator as Faker;

$factory->define(StatusEffect::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'type' => $faker->word,
        'description' => $faker->paragraph,
    ];
});
