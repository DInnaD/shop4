<?php

namespace App\Http\Controllers;

use Auth;
use App\Magazin;
use App\Book;
use App\Order;
use App\Purchase;
use Illuminate\Http\Request;

class OrdersAllsController extends Controller
{

    public function verifySecond($token)
    {
        $ordersAll = OrdersAll::where('tokenSecond', $token)->firstOrFail();
        $ordersAll->tokenSecond = null;
        $ordersAll->save();
        return redirect('/')->with('status', 'Your promocode on your mail!');
    }

    public function verify($token)
    {
        $ordersAll = OrdersAll::where('token', $token)->firstOrFail();
        $ordersAll->token = null;
        $ordersAll->save();
        return redirect('/')->with('status', 'Your Order on your mail!');
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersAll $ordersAll)
    {
		$ordersAlls = OrdersAll::orderBy('id', 'asc')->get();
		return view('homes.indexAll', compact('ordersAlls'));
        //return view('purchases.ordersAll', ['ordersAlls' => OrdersAll::get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
		return view('ordersAll.show', compact('ordersAll'));
    }

}
