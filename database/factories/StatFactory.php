<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stat;
use Faker\Generator as Faker;

$factory->define(Stat::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'abbreviation' => $faker->word,
    ];
});
