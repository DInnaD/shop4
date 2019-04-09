<?php

namespace App\Http\Controllers\Admin;

use App\OrdersAll;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
/**
   * Доставка данного заказа.
   *
   * @param  Request  $request
   * @param  int  $orderId
   * @return Response
   */
  public function ship(Request $request, $id)//subId - ? for custom Mail/OrdShip
  {
    $subs = Subscription::findOrFail($id);

    // Доставка заказа...

    Mail::to($request->user())->send(new OrderShipped($sub));
  }
}
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subs = Subscription::all();

        return view('admin.subs.index', ['subs'=>$subs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' =>  'required|email|unique:subscriptions'
        ]);

        Subscription::add($request->get('email'));

        return redirect()->route('subscribers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subscription::find($id)->delete();
        return redirect()->route('subscribers.index');
    }
}
