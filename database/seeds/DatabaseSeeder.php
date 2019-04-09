<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
        BooksTableSeeder::class,
        MagazinsTableSeeder::class,
        OrdersAllsTableSeeder::class,
        OrdersTableSeeder::class,
        PurchasesTableSeeder::class,
        UsersTableSeeder::class

    	]);
    }
}
