<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('ordersAll_id')->nullable()->unsigned();
            $table->integer('order_id')->nullable()->unsigned();
            $table->integer('book_id')->nullable()->unsigned();
            $table->integer('magazin_id')->nullable()->unsigned();
            $table->date('date')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('qty_m')->nullable();
            $table->integer('status_bought')->default(0);//buy button click with new order_id
            $table->integer('status_paied')->default(0);//if admin saw money an acount
            $table->integer('status_sub_price')->default(0);            
            $table->timestamps();
            });

            Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ordersAll_id')->references('id')->on('orders_alls');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('magazin_id')->references('id')->on('magazins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
       // $table->dropForeign('purchases_user_id_foreign');
    }
}
