<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => 'test@gmail.com'		,//$faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('123456'),
        //'remember_token' => str_random(10),
        'status_discont_id' => $faker->boolean(),
        'discont_id' => $faker->numberBetween(5, 15), 

    ];
});

// $factory->define(App\User::class, 'admin', function (Faker $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => 'test@gmail.com',
//         'email_verified_at' => now(),
//         'password' => Hash::make('123456'),
//         'remember_token' => str_random(10),
//         //'user_type' => 3,User', 3)->create(['user_type'=>3]); // Create 3 admin users migr user_type->default(0);
//     ];
// });









