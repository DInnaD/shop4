<?php

namespace App\Http\Controllers;

use Auth;
use App\Magazin;
use App\Book;
use App\Order;
use App\OrdersAll;
use App\Purchase;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Purchase::class, 'purchase');//('update', $purchase);
    }

    public function toggleBeforeToggle($id)
    {

        $purchase = Purchase::find($id);//where it got// order in toggle
        $purchase->toggleStatusBuy();

            
        return redirect()->back();
    }

    public function toggleSubPrice($id)
    {

        $purchase = Purchase::find($id);//where it got// order in toggle
        $purchase->toggleStatusSubPrice();

            
        return redirect()->back();
    }

    // public function sendEmail($id){
    // try{
    //     $user = User::find($id);
    //     $data = array('name' => $trainee->name,'email' => $trainee->email);
    //     Mail::send('emails.haptics', $data, function($message) use ($data){
    //         $message->to($data['email'], $data['name'])->subject('Test Subject');
    //     });
    //         alert()->success('Emails Sending complete', 'Messages sent');
    //         return back();
    // }
    //}

    //Pay button on the cart//showAlls button on the cart
    public function buy(Request $request)//, $summa
    {

        $user_id = \Auth::user()->id;
        $purchases = Purchase::where('user_id', $user_id)->where('status_bought', '!=', '0')->where('status_paied', '!=', '1')->get();
 
        $ordersAll = new OrdersAll(); 
        $ordersAll = OrdersAll::add($request->all());
        $ordersAll->user_id = \Auth::user()->id;        
        //$ordersAll->send();                
        //$ordersAll->generateToken();
        //
        //1.or promo one for all time ....no:next 2.other promo each time && have no subscription 
        if($ordersAll->author->status_discont_id != 1 && $ordersAll->purchases()->status_sub_price != 0)// next 2.!empty($ordersAll->author->discont_id_promocode))...no users table field 'discont_id_promocode'
        {
            //$ordersAll->sendSecond();
            //$ordersAll->generateTokenSecond();
        }
        foreach ($purchases as $purchase) 
        {            
            $purchase->ordersAll_id = $ordersAll->id;
            //no discont_id_promocode >=always??? or status_author->discont_id && global//no $summa: formula & AsAll->purch->...
            //tempolary author discont_id use promo
            if($purchase->first()->book->discont_id_promocode != 1 && $purchase->author->status_discont_id == 0)//...no table field, no toggleDiscontIdPromocode()...after verify sendSecond() //discont_id_promocode made by admin... no view field no modelno controll field
            {
                $purchase->author->discont_id = $purchase->book->promocode;
                $purchase->book->makeVisibleDiscontPROMOB();//request of sendSecond();
                $purchase->author->makeVisibleDiscontId();
            }// elseif($ordersAll->author->status_discont_id == 1)
            
            if(($purchase->magazin->discont_id_promocode != 1 && $purchase->magazin->sub_price == 0) && $purchase->author->status_discont_id != 1)//...no table field, no toggleDiscontIdPromocode()...after verify sendSecond() //discont_id_promocode made by admin... no view field no modelno controll field
            {
                $purchase->author->discont_id = $purchase->magazin->promocode;
                $purchase->magazin->makeVisibleDiscontPROMOB();//request of sendSecond();
                $purchase->author->makeVisibleDiscontId();
            }// elseif($ordersAll->author->status_discont_id == 1 && $ordersAll->purchases()->magazin->sub_price == 0)// elseif($ordersAll->author->status_discont_id == 1 && $ordersAll->purchases()->magazin->sub_price != 0)
        }        
            // $ordersAll->getQtySum($request->get('number'));
            // $ordersAll->getQty($request->get('qty'));
            // $ordersAll->getQty_m($request->get('qty_m'));
            // $ordersAll->getSum($request->get('sum'));
            //$ordersAll->getDate($request->get('date'));
               
        $ordersAll->save();

        $order = new Order();//naznachyty id ordersAll ids orders ???$ordersAll->id???peredaty?????
        $ordersAlls = Order::pluck('created_at', 'id')->all();
        $order = Order::add($request->all());
        $order->user_id = \Auth::user()->id; 
        $order->ordersAlls()->attach($request->get('ordersAlls'));
        foreach ($purchases as $purchase) 
        {            
            $purchase->order_id = $order->id;
            $purchase->toggleStatus();
        } 
        $order->save();

        return redirect()->route('cart')->with('status_paied','Check your email!');//to payment service
    } 

//         //if update

//         // $order = Orders::find($id);
//         // $ordersAlls = Order::pluck('created_at', 'id')->all();
//         // $selectedOrdersAlls = $order->ordersAllls->pluck('id')->all();
//         //



// //true
//         $ordersAlls = Order::pluck('created_at', 'id')->all();
//          //$order = Order::add($request->get('id'));//collect
//          $order = Order::add($request->all());
//          $order->user_id = \Auth::user()->id; 
//          $order->ordersAlls()->attach($request->get('ordersAlls'));



// //$order->setOrdersAlls($request->get('ordersAlls'));
// //to App\Order 
//     //     public function setOrdersAlls($ids)
//     // {
//     //     if($ids == null){return;}

//     //     $this->ordersAlls()->sync($ids);
//     // }
//         //public function getOrdersAllsDates()
//     // {
//     //     return (!$this->ordersAlls->isEmpty())
//     //         ?   implode(', ', $this->ordersAlls->pluck('created_at')->all())
//     //         : 'No Orders All';
//     // }
//         //extraInfo make already ~user from new obj of class
//         foreach ($purchases as $purchase) 
//         {
            
//             $purchase->order_id = $order->id;
            
//             //1. Delete all items from view http://shop/order(that items I can see in the next http://shop/orderall) and http://shop/cart(sum not count in the cart); with 'status_paied' == 0 to == 1. 

//             $purchase->toggleStatus(); 
            
//             //for clean cart instead next if{remove}
//             // if($purchase->status_bought == 1)
//             // {
//             //     //?????to virtual-trash: neither 1 nor 0
//             //     $purchase->status_bought = 2;
//             // }

//         } 

//         $order->save();

//         // $ordersAll_id = $purchase->ordersAll->id;
//         // $purchases = Purchase::where('user_id', $user_id)->where('status_bought', '!=', '0')->where('status_paied', '!=', '0')->where('ordersAll_id', $ordersAll_id)->get();
//         // foreach($purchases as $purchase)
//         // {
//         //     $ordersAll = OrdersAll::find($id);
//         //     $ordersAll->edit($request->all());
//         //     $ordersAll->getQtySum($request->get('number'));
//         //     if($ordersAll->purchase()->book == 1)//need test
//         //         {
//         //             $ordersAll->getQty($request->get('qty'));
//         //             } elseif($ordersAll->purchase()->book != 1)//need test
//         //                     {
//         //                         $ordersAll->getQty_m($request->get('qty_m'));
//         //                     }
//         //     $ordersAll->getSum($request->get('sum'));
//         //     $ordersAll->getDate($request->get('date'));
//         //     $ordersAll->save();
//         // }            

        

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexCart()
    {
        $user_id = \Auth::user()->id;
        //auto clean cart when account paid confirm with 'status_paied' == 0
        if(true)
        {
            //Delete all items from view
            $purchases = Purchase::where('user_id', $user_id)->where('status_bought', '!=', '0')->where('status_paied', '==', '0')->get();

            return view('purchases.index', ['purchases'=>$purchases]);

        } 

        return view('purchases.thanksForPaid');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Purchase $purchase, Book $book, Magazin $magazin)
    {

         $user_id = \Auth::user()->id;
         $purchases = Purchase::all()->where('user_id', $user_id)->where('status_paied', '!=', '1');

        return view('homes.pay', ['purchases'=>$purchases]);
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if($purchase->book_id != null){
        // if($purchase->book->status == 1)
        // {
        //         $this->validate($request, [
        //             'qty'   =>  'required'
        //         ]);//not 0
        // }
        // else{
        //         $this->validate($request, [
        //             'qty_m'   =>  'required'
        //         ]);//not 0
        // }
        $purchase = Purchase::add($request->all());
        if($purchase->book->status == 1)
        {
        $purchase->qty = $request->get('qty');
        } elseif($purchase->magazin->status == 0)
        {
        $purchase->qty_m = $request->get('qty_m');
        }
        $purchase->book_id = $request->get('book_id');
        $purchase->magazin_id = $request->get('magazin_id');
        $purchase->user_id = \Auth::user()->id;

        $purchase->save();

        
        return redirect()->route('purchases.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //edit qty qty_m
        $purchase = Purchase::find($id);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $purchase = Purchase::find($id);
        if($purchase->book->status == 1)
        {
        $purchase->edit($request->get('qty'));
        } if($purchase->magazin->status == 0)
            {
                $purchase->edit($request->get('qty_m'));
            }    

        return redirect()->route('cart');
        
    }
    //     public function update(Request $request, Purchase $purchase)
    // {
    //     $purchase->update($request->all());
    //     return redirect()->route('cart');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        Purchase::find($id)->remove();
        return redirect()->back();
    }

    public function destroyAll(Request $request)
    {
        $user_id = \Auth::user()->id;
        $purchases = Purchase::all()->where('user_id', $user_id)->where('status_paied', '==', '0');
        foreach ($purchases as $purchase) {

            $purchase->remove();
        }
        return redirect()->back();
    }
   
}
