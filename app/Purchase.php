<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
//use Cviebrock\EloquentSluggable\Sluggable;

class Purchase extends Model
{
    //use Sluggable;
    const SUMMA = 0;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['book_id', 'magazin_id', 
        'user_id', 'order_id', 'status_bought','status_paied', 'date', 'qty_m', 'qty', 'price', 'sum', 'sum_m', 'book_or_mag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

        public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function magazin()
    {
        return $this->belongsTo(Magazin::class);
    }

    public function author()//isAdmin
    {
        return $this->belongsTo(User::class, 'user_id');
    }  

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

        public function ordersAll()
    {
        return $this->belongsTo(OrdersAll::class);
    }

    public static function add($fields)
    {// var_dump(get_called_class());
    	$purchase = new static;
    	$purchase->fill($fields);
    	$purchase->book_id = $purchase->first()->book->id;
    	$purchase->magazin_id = $purchase->magazin->id;
    	$purchase->user_id = \Auth::user()->id;
    	$purchase->save();

    	return $purchase;

    }

    public function edit($fields)
    {
    	$this->fill($fields);
        // $this->qty = $fields['qty'];
        // $this->qty_m = $fields['qty_m'];
    	$this->save();
    }

    public function remove()
    {
    	//$this->removeImage();
    	$this->delete();
    }


    public function Buy()
    {
    	
    	$this->status_bought = 1;
    	$this->save();
    	
    }

    public function disBuy()
    {
    	$this->status_bought = 0;
    	$this->save();
    }

    public function toggleStatusBuy()
    {
    	if($this->status_bought == 0)
    	{
    		return $this->Buy();
    	}

    	return $this->disBuy();
    }    
    //for admin controller
    public function pay()
    {
    	
    	$this->status_paied = 1;
    	$this->save();
    	
    }

    public function disPay()
    {
    	$this->status_paied = 0;
    	$this->save();
    }

    public function toggleStatus()
    {
    	if($this->status_paied == 0)
    	{
    		return $this->pay();
    	}

    	return $this->disPay();
    }

        public function sub()
    {
        
        $this->status_sub_price = 1;
        $this->save();
        
    }

    public function disSub()
    {
        $this->status_sub_price = 0;
        $this->save();
    }

    public function toggleStatusSubPrice()
    {
        if($this->status_sub_price == 0)
        {
            return $this->sub();
        }

        return $this->disSub();
    }

    public function setDateAttribute()
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');

        return $date;
    }

    public function getDate()
    {
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }
    //$summa for viev not ordersAlls
    public function getSumma()//on the view formula
    {
        // $summa += $purchase->book->price * qty + $purchase->magazin->price * qty_m;///count() from purch to order    
        $summa = 0;

        foreach ($purchases as $purchase) 

        {//place for future comments

            if($purchase->status_bought == 1)

            {
                if($purchase->magazin->sub_price != 0)

                {
                    $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->sub_price / 100)) * 12;
                }else

                  {

                    if($purchase->first()->book->author->status_discont_id == 1 && $purchase->first()->book->discont_privat != 0 && $purchase->magazin->author->status_discont_id == 1 && $purchase->magazin->discont_privat != 0)

                    {//

                        if (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2)) 

                        {//

                            $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

                            } elseif(round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

                            {//

                                $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

                                } elseif (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

                                {//

                                    $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

                                    } elseif (round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2) && round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2))

                                    {//

                                        $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

                                        } elseif (round($purchase->first()->book->discont_global,2) >= round($purchase->first()->book->author->discont_id,2))

                                        {//

                                            $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty  + $purchase->magazin->price * $purchase->qty_m;//

                                            } elseif (round($purchase->first()->book->discont_global,2) <= round($purchase->first()->book->author->discont_id,2))

                                            {//

                                                $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

                                                } elseif (round($purchase->magazin->discont_global,2) >= round($purchase->magazin->author->discont_id,2))

                                                {//

                                                    $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                                                    } elseif (round($purchase->magazin->discont_global,2) <= round($purchase->magazin->author->discont_id,2))

                                                    {//

                                                        $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                                                    }

                    //                               
                    } elseif($purchase->first()->book->discont_privat != 0 && $purchase->magazin->discont_privat != 0)

                        {//
                            if($purchase->first()->book->discont_privat != 0) 

                            {//

                                $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;


                            }

                                elseif($purchase->magazin->discont_privat != 0) 

                                {//

                                    $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                                }

                            $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m;

                        //
                        } elseif($purchase->first()->book->author->status_discont_id == 1 && $purchase->magazin->author->status_discont_id == 1)

                            {//

                                if($purchase->first()->book->author->status_discont_id == 1) 

                                {//
                                    $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

                                }
                                    elseif($purchase->magazin->author->status_discont_id == 1) 

                                    {//

                                        $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m + $purchase->first()->book->price  * $purchase->qty;

                                    }

                                $summa += ($purchase->first()->book->price - ($purchase->first()->book->price * $purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m;

                            //    
                            } else 

                                    {//

                                    $summa += $purchase->first()->book->price  * $purchase->qty + $purchase->magazin->price * $purchase->qty_m;

                                    }
                    }  
            }     

        }
        return $summa;//self??

    }

    public function getQuantitySum($sumQty, $sumQty_m)
    {//$this->math(getQuantity(),getQuantity_m());$this->save;???????
        $sumQty = 0;          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
            {
                        $sumQty = ($sumQty += $purchase->qty) + ($sumQty_m += $purchase->qty_m);
            }

        }
    }


    public function getQuantity()
    {
        $sumQty = 0;
                          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
            {
                        $sumQty += $purchase->qty;
            }

        }
        return $sumQty;
    }    

    public function getQuantity_m()
    {
        $sumQty_m = 0;
                          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
            {
                        $sumQty_m += $purchase->qty_m;
            }

        }
        return $sumQty_m;
    }       
  
}
