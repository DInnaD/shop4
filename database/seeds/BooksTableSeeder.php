<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
//    	$purchase = factory(App\Purchase::class)->create();
    	factory(App\Book::class, 40)->create();//->each(function ($book) use ($purchase){
    		// $purchase->book()->attach($book);
    		// $book->purchase()->save(factory(App\Book::class)->make());
    	//});
        
        // DB::table('books')->insert([
        //     'user_id' => random(1,3),
        //     'category_id' => random(1,4),
        //     'name' => Str::random(5),
        //     'author_name' => Str::random(5),
        //     'page' => random(50,400),
        //     'autor' => Str::random(5),
        //     'year' => random(2010,2019),
        //     'is_hard' => (bool)random_int(0, 1),
        //     'is_hard_hard' => (bool)random_int(0, 1),
        //     'kindof' => Str::random(5),
        //     'size' => random(50,100),
        //     'price' => random(100,500),
        //     'old_price' => random(90,500),
        //     'discont_global' => random(4,20),
        //     'discont_privat' => (bool)random_int(0, 1),
        // ]);
    }
}
