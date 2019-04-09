<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	

    	// $purchase = factory(App\Purchase::class)->create();
    	// $ordersAll = factory(App\OrdersAll::class)->create();

    	factory(App\Order::class, 5)->create();//->each(function ($order) use ($purchase, $ordersAll){
    		// $purchase->order()->attach($order);
    		// $ordersAll->orders()->attach($order);
      //   	$order->purchases()->save(factory(App\Purchase::class)->make());
      //   	$order->ordersAlls()->save(factory(App\OrderAll::class)->make());
        //});
        // DB::table('orders')->insert([
        //     'user_id' => random(1,3),
        // ]);
    }
}
