<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Element;
use Faker\Generator as Faker;

$factory->define(Element::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
