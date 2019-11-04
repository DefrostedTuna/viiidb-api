<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SeedRank;
use Faker\Generator as Faker;

$factory->define(SeedRank::class, function (Faker $faker) {
    return [
        'rank' => $faker->numberBetween(1, 30),
        'salary' => $faker->numberBetween(500, 30000),
    ];
});
