<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SeedTest;
use Faker\Generator as Faker;

$factory->define(SeedTest::class, function (Faker $faker) {
    return [
        'level' => $faker->numberBetween(1, 30),
    ];
});
