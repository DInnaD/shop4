<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\Purchase::class)->create([
    	//'user_id' => User::where('email', 'like', 'test@gmail.com')->get()->$faker->randomBetween($min = 2, $max = 4)->user_id,
    	// 'book_id' => Book::where('id', 'like', 'id')->get()->random()->book_id,
    	// 'magazin_id' => Magazin::where('id', 'like', 'id')->get()->random()->magazin_id,
    	// 'ordersAll_id' => OrdersAll::where('id', 'like', 'id')->get()->random()->orderAll_id,
    	// 'order_id' => Order::where('id', 'like', 'id')->get()->random()->order_id,
        'qty' => '1',
        'qty_m' => '1',
        'status_bought' => $faker->boolean(),
        'status_paied' => $faker->boolean(),
    
        
    ]);
    	factory(App\Purchase::class, 5)->create();
        // DB::table('purchases')->insert([
        //     'user_id' => random(1,3),
        //     'ordersAll_id' => random(1,4),
        //     'order_id' => random(1,5),
        //     'book_id' => random(1,40),
        //     'magazin_id' => random(1,40),
        //     'qty' => random(1,2),
        //     'qty_m' => random(1,2),
        //     'status_bought' => (bool)random_int(0, 1),
        //     'status_paied' => (bool)random_int(0, 1),
        // ]);
    }
}
