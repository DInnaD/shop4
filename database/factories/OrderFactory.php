<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
    	//'user_id' => User::where('email', 'like', 'test@gmail.com')->get()->randomBetween($min = 2, $max = 4)->user_id,
        
    ];
});
