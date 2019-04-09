<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
    	//'user_id' => User::where('email', 'like', 'test@gmail.com')->get()->randomBetween($min = 2, $max = 4)->user_id,
        'name' => $faker->sentence(4, true),
        'author_name' => $faker->name,
        'page' => $faker->numberBetween(50, 500),
        'autor' => $faker->word,
        'year' => $faker->numberBetween(2010, 2019),
        'is_hard' => $faker->boolean(),
        'is_hard_hard' => $faker->boolean(),
        'kindof' => $faker->word,
        'size' => $faker->numberBetween(20, 40),
        'price' => $faker->randomFloat(2, 100, 500),
        'discont_global' => '10',
        'discont_privat' => $faker->boolean(),
    ];
});
