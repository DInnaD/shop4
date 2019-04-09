<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\User::class)->create([

        'name' => 'name',
        'email' => 'test@gmail.com'		,//$faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('123456'),
        'status_discont_id' => $faker->boolean(),
        'discont_id' => $faker->numberBetween(5, 15),

    ]);

    	//$purchase = factory(App\Purchase::class)->create();
    	//$order = factory(App\Order::class)->create();
    	//$ordersAll =factory(App\OrdersAll::class)->create();
    	factory(App\User::class, 3)->create();//->each(function ($user) use ($purchase, $order, $ordersAll){
    		// $purchase->author()->attach($user);
    		// $order->author()->attach($user);
    		// $ordersAll->author()->attach($user);
    		// $user->purchase()->save(factory(App\Purchase::class)->make());
    		// $user->order()->save(factory(App\Order::class)->make());
    		// $user->ordersAll()->save(factory(App\OrdersAll::class)->make());
    		
    	//});

    	// $book = factory(App\Book::class, 'admin')->create();
    	// $magazin = factory(App\Magazin::class, 'admin')->create();
    	
    	// factory(App\User::class, 'admin', 1)->create()->each(function ($user) use ($book, $magazin){
    	// 	$book->author()->attach($user);
    		
    	// 	$magazin->author()->attach($user);
    	// 	$user->book()->save(factory(App\Book::class, 'admin')->make());
    	// 	$user->magazin()->save(factory(App\Magazin::class, 'admin')->make());
    		
    	// });

    	
    	
        // DB::table('users')->insert([
        //     'name' => Str::random(5),
        //     'email' => Str::random(5).'@gmail.com',
        //     'password' => bcrypt('secret'),
        //     'status_discont_id' => (bool)random_int(0, 1),
        //     'discont_id' => random(5,15),
        // ]);
    }
}
