<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Magazin::class, function (Faker $faker) {
    return [
        //'user_id' => User::where('email', 'like', 'test@gmail.com')->get()->randomBetween($min = 2, $max = 4)->user_id,
        'name' => $faker->sentence(4, true),
        'page' => $faker->numberBetween(50, 500),
        'autor' => $faker->word,
        'number_per_year' => $faker->numberBetween(500000, 50000000),
        'year' => $faker->numberBetween(2017, 2019),
        'number' => $faker->numberBetween(1, 40),
        'size' => $faker->numberBetween(30, 40),
        'price' => $faker->randomFloat(2, 100, 200),
        'discont_global' => '10',
        'discont_privat' => $faker->boolean(),
    ];
});
