<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MagazinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
 //   	$purchase = factory(App\Purchase::class)->create();
    	factory(App\Magazin::class, 40)->create();//->each(function ($magazin) use ($purchase){
    		// $purchase->magazin()->attach($magazin);
      //   	$magazin->purchase()->save(factory(App\Magazin::class)->make());
        //});
        
        // DB::table('magazins')->insert([
        //     'user_id' => random(1,3),
        //     'category_id' => random(1,4),
        //     'name' => Str::random(40),
        //     'page' => random(10,40),
        //     'autor' => Str::random(40),
        //     'number_per_year' => random(1000000,2000000),
        //     'year' => random(2018,2019),
        //     'number' => random(1,40),
        //     'size' => random(10,40),
        //     'price' => random(90,200),
        //     'sub_price' => random(70,300),
        //     'old_price' => random(90,500),
        //     'discont_global' => random(4,20),
        //     'discont_privat' => (bool)random_int(0, 1),
        // ]);
    }    
}
