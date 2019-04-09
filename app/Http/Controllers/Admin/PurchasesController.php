<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Purchase::class, 'purchase');
    }

	public function index()
    {
// status_paied, '!=', '0':it means: == 1 && == 2 
//+ add if status_paied == 1 more then 3 days:

        //if(3>days)
        //$purchases = Purchase::where('status_paied', '==', '1');
        //elseif
        //$purchases = Purchase::where('status_paied', '==', '1');
        //else
        //$purchases = Purchase::where('status_paied', '==', '2');
        //add view sortBy('status_ppaied')
        $purchases = Purchase::where('status_bought', '!=', '0')->where('status_paied', '!=', '0')->get();
        return view('admin.purchases.index', ['purchases'=>$purchases]);
        // return $user->id === $purchase->update_by;//is it instead of mytoggle_status_paied?
    }
    
    public function toggle($id)
    {
        $purchase = Purchase::find($id);
        $purchase->toggleStatus();


        return redirect()->back();
    }

    public function indexDayBefore()
    {
        $day = new \DateTime('now');
        $day = $day->sub(new \DateInterval('P1D'));
        //dd(time() - 1 * 24 *60 * 60);
        $purchases = Purchase::where('created_at', '>', $day)->get();

        
        foreach ($purchases as $purchase) 
        {
            //$purchase->getSum($summa)
            //$purchase->getQuantitySum($sumQty, $sumQty_m)
            //$purchase->getQuantity($sumQty)
            //$purchase->getQuantity_m($sumQty_m)
            //Top-5 Books
            $purchase->book = Purchase::where('qty')->orderBy('qty','desc')->take(5)->get();
            //Top-5 Magazins
            $purchase->magazin = Purchase::where('qty_m')->orderBy('qty_m','desc')->take(5)->get();

        }
        return view('admin.purchases.index', ['purchases'=>$purchases]);
    }

    public function indexWeekBefore($summa, $sumQty, $sumQty_m)
    {

        $day = new \DateTime('now');
        $day = $day->sub(new \DateInterval('P7D'));

        $purchases = Purchase::where('created_at', '>', $day)->get();

        foreach ($purchases as $purchase) 
        {
            //$purchase->getSum($summa)
            //$purchase->getQuantitySum($sumQty, $sumQty_m)
            //$purchase->getQuantity($sumQty)
            //$purchase->getQuantity_m($sumQty_m)
            //Top-5 Books
            $purchase->book = Purchase::where('qty')->orderBy('qty','desc')->take(5)->get();
            //Top-5 Magazins
            $purchase->magazin = Purchase::where('qty_m')->orderBy('qty_m','desc')->take(5)->get();

        }
        
        
        return view('admin.purchases.index', ['purchases'=>$purchases]);
    }

    public function indexMonthBefore()
    {
        $day = new \DateTime('now');
        $day = $day->sub(new \DateInterval('P1M0D'));

        $purchases = Purchase::where('created_at', '>', time() - 30 * 24 *60 * 60)->get();

        foreach ($purchases as $purchase) 
        {
            //$purchase->getSum($summa)
            //$purchase->getQuantitySum($sumQty, $sumQty_m)
            //$purchase->getQuantity($sumQty)
            //$purchase->getQuantity_m($sumQty_m)
            //Top-5 Books
            $purchase->book = Purchase::where('qty')->orderBy('qty','desc')->take(5)->get();
            //Top-5 Magazins
            $purchase->magazin = Purchase::where('qty_m')->orderBy('qty_m','desc')->take(5)->get();

        }

        return view('admin.purchases.index', ['purchases'=>$purchases]);
    }
    
}
