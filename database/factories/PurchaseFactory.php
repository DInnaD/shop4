<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
    	//'user_id' => User::where('email', 'like', 'test@gmail.com')->get()->$faker->randomBetween($min = 2, $max = 4)->user_id,
    	// 'book_id' => Book::where('id', 'like', 'id')->get()->random()->book_id,
    	// 'magazin_id' => Magazin::where('id', 'like', 'id')->get()->random()->magazin_id,
    	// 'ordersAll_id' => OrdersAll::where('id', 'like', 'id')->get()->random()->orderAll_id,
    	// 'order_id' => Order::where('id', 'like', 'id')->get()->random()->order_id,
        'qty' => '1',
        'qty_m' => '1',
        'status_bought' => $faker->boolean(),
        'status_paied' => $faker->boolean(),
    
        
    ];
});

