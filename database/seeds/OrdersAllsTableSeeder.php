<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersAllsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	

     //    $purchase = factory(App\Purchase::class)->create();
    	// $order = factory(App\Order::class)->create();
    		
        factory(App\OrdersAlls::class, 4)->create();//->each(function ($ordersAll) use ($purchase, $order){
      //   	$purchase->order()->attach($order);
    		// $order->ordersAlls()->attach($ordersAll);
      //   	$ordersAll->purchases()->save(factory(App\Purchase::class)->make());
      //   	$ordersAll->orders()->save(factory(App\Order::class)->make());
      //   });
        
        // DB::table('orders_alls')->insert([
        //     'user_id' => random(1,3),
        // ]);   
    }
}
