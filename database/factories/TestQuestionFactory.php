<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TestQuestion;
use Faker\Generator as Faker;

$factory->define(TestQuestion::class, function (Faker $faker) {
    return [
        'seed_test_id' => null,
        'question_number' => $faker->numberBetween(1, 10),
        'question' => $faker->paragraph,
        'answer' => $faker->randomElement(['yes', 'no']),
    ];
});
