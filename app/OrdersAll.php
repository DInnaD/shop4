<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
//use Cviebrock\EloquentSluggable\Sluggable;

class OrdersAll extends Model
{
    protected $fillable = ['user_id', 'number', 'qty', 'qty_m', 'sum', 'date'];

    public function author()//isAdmin
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function orders()
    {

    	return $this->belongsToMany('App\Orders')->withTimestamps();//->Pivot('price');$ordesAll->orders()->where('aorders_bordersalls', $order->id)->first()->pivot->price;
    }

    // public function getRecepient(){
    //     //return array_column($this->author(s), 'email');
        
    //     return $ordersAll;
    // }

    public function send()
    {
        \Mail::to($this->author->email)->send(new OrderShipped($this)); 
    //     \Mail::to(array_merge($this->getRecepient(), $this->getRequiredRecepients()))->send(new OrderShipped($this));
     }
    //if itemhas promocode wit discont_id and status_discontId//future
    public function sendSecond()
    {
        $when = Carbon\Carbon::now()->addMinutes(1);
        \Mail::to($this->author->email)->later($when, new OrderShippedSecond($this));//->send(new OrderShipped($ordersAll));//$this
    //     \Mail::to(array_merge($this->getRecepients(), $this->getRequiredRecepients()))->later($when, new OrderShippedSecond($this));//no new OrderShippedSecond
     }
    //the same message as confirm to admin email
    //  public function getRequiredRecepients(){
    //     return ['innassik@yahoo.com'];
    // }
    public function generateTokenSecond()
    {
        $this->tokenSecond = str_random(100);
        $this->save();
    }

    public function generateToken()
    {
        $this->token = str_random(100);
        $this->save();
    }
    public static function add($fields)
    {// var_dump(get_called_class());
        $ordersAll = new static;
        $ordersAll->fill($fields);         
        $ordersAll->user_id = \Auth::user()->id;
        $ordersAll->save();

        return $ordersAll;

    }

    // public function edit($id)
    // {
    //     $this->OrdersAll::find($id);
    //     $this->fill($fields);
    //     $this->getQtySum($request->get('number'));
    //     $this->getQty($request->get('qty'));
    //     $this->getQty_m($request->get('qty_m'));
    //     $this->getSum($request->get('sum'));
    //     $this->getDate($request->get('date'));
    //     $this->save();
    // }

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

    public function getQuantity()
    {
        $sumQty = 0;
                          
        foreach($ordersAlls as $ordersAll)
        {

            if($ordersAll->purchase->status_bought == 1)
            {
                        $sumQty += $ordersAll->purchase->qty;
            }

        }
        return $sumQty;
    }    

    public function getQuantity_m()
    {
        $sumQty_m = 0;
                          
        foreach($ordersAlls as $ordersAll)
        {

            if($ordersAll->purchase->status_bought == 1)
            {
                        $sumQty_m += $ordersAll->purchase->qty_m;
            }

        }
        return $sumQty_m;
    }

    public function getQty($qty)
    {
        if($qty != null)
        {
            $this->sum = getQuantity($qty);
            $this->save();
        }

    }

    public function getQty_m($qty_m)
    {
        if($qty_m != null)
        {
            $this->sum = getQuantity_m($qty_m);
            $this->save();
        }

    }

    public function getQtySum($qty, $qty_m)
    {
        if($qty != null && $qty_m != null)
        {
            $this->number = getQty() + getQty_m();
            $this->save();
        }

    }

    public function getSum($summa)
    {
        if($summa != null)
        {
            $this->sum = getSumma();
            $this->save();
        }
    }
    //$summa for new OrdersAll
    public function getSumma()
    {
        // $summa += $purchase->book->price * qty + $purchase->magazin->price * qty_m;///count() from purch to order    
        $summa = 0;

        foreach ($ordersAlls as $ordersAll) 

        {//place for future comments

            if($ordersAll->purchase->status_paied == 1)
            {

                if($ordersAll->purchase()->status_sub_price != 0)

                {
                    $summa += ($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->sub_price / 100)) * 12;

                }else

                    {

                    if($ordersAll->purchase->first()->book->author->status_discont_id == 1 && $ordersAll->purchase->first()->book->discont_privat != 0 && $ordersAll->purchase->magazin->author->status_discont_id == 1 && $ordersAll->purchase->magazin->discont_privat != 0)

                    {//

                        if (round($ordersAll->purchase->first()->book->discont_global,2) >= round($ordersAll->purchase->first()->book->author->discont_id,2) && round($ordersAll->purchase->magazin->discont_global,2) >= round($ordersAll->purchase->magazin->author->discont_id,2)) 

                        {//

                            $summa += ($ordersAll->purchase->first()->book->price - ($purchase->first()->book->price * $ordersAll->purchase->first()->book->discont_global / 100)) * $ordersAll->purchase->qty + ($ordersAll->purchase->magazin->price - ($purchase->magazin->price * $ordersAll->purchase->magazin->discont_global / 100)) * $ordersAll->purchase->qty_m;

                            } elseif(round($ordersAll->purchase->first()->book->discont_global,2) <= round($ordersAll->purchase->first()->book->author->discont_id,2) && round($ordersAll->purchase->magazin->discont_global,2) <= round($ordersAll->purchase->magazin->author->discont_id,2))

                            {//

                                $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $ordersAll->purchase->first()->book->author->discont_id / 100)) * $ordersAll->purchase->qty + ($rdersAll->purchase->magazin->price - ($rdersAll->purchase->magazin->price * $ordersAll->purchase->magazin->author->discont_id / 100)) * $ordersAll->purchase->qty_m;

                                } elseif (round($ordersAll->purchase->first()->book->discont_global,2) >= round($ordersAll->purchase->first()->book->author->discont_id,2) && round($ordersAll->purchase->magazin->discont_global,2) <= round($ordersAll->purchase->magazin->author->discont_id,2))

                                {//

                                    $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $purchase->first()->book->discont_global / 100)) * $ordersAll->purchase->qty + ($ordersAll->purchase->magazin->price - ($purchase->magazin->price * $ordersAll->purchase->magazin->author->discont_id / 100)) * $ordersAll->purchase->qty_m;

                                    } elseif (round($ordersAll->purchase->first()->book->discont_global,2) <= round($ordersAll->purchase->first()->book->author->discont_id,2) && round($ordersAll->purchase->magazin->discont_global,2) >= round($ordersAll->purchase->magazin->author->discont_id,2))

                                    {//

                                        $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $ordersAll->purchase->first()->book->author->discont_id / 100)) * $purchase->qty + ($ordersAll->purchase->magazin->price - ($ordersAll->purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $ordersAll->purchase->qty_m;

                                        } elseif (round($ordersAll->purchase->first()->book->discont_global,2) >= round($ordersAll->purchase->first()->book->author->discont_id,2))

                                        {//

                                            $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $ordersAll->purchase->first()->book->discont_global / 100)) * $ordersAll->purchase->qty  + $ordersAll->purchase->magazin->price * $ordersAll->purchase->qty_m;//

                                            } elseif (round($ordersAll->purchase->first()->book->discont_global,2) <= round($ordersAll->purchase->first()->book->author->discont_id,2))

                                            {//

                                                $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $ordersAll->purchase->first()->book->author->discont_id / 100)) * $ordersAll->purchase->qty + $ordersAll->purchase->magazin->price * $ordersAll->purchase->qty_m;

                                                } elseif (round($ordersAll->purchase->magazin->discont_global,2) >= round($ordersAll->purchase->magazin->author->discont_id,2))

                                                {//

                                                    $summa += ($ordersAll->purchase->magazin->price - ($ordersAll->purchase->magazin->price * $ordersAll->purchase->magazin->discont_global / 100)) * $ordersAll->purchase->qty_m + $ordersAll->purchase->first()->book->price  * $ordersAll->purchase->qty;

                                                    } elseif (round($ordersAll->purchase->magazin->discont_global,2) <= round($ordersAll->purchase->magazin->author->discont_id,2))

                                                    {//

                                                        $summa += ($ordersAll->purchase->magazin->price - ($ordersAll->purchase->magazin->price * $ordersAll->purchase->magazin->author->discont_id / 100)) * $ordersAll->purchase->qty_m + $ordersAll->purchase->first()->book->price  * $ordersAll->purchase->qty;

                                                    }

                    //                               
                    } elseif($ordersAll->purchase->first()->book->discont_privat != 0 && $ordersAll->purchase->magazin->discont_privat != 0)

                        {//
                            if($ordersAll->purchase->first()->book->discont_privat != 0) 

                            {//

                                $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $ordersAll->purchase->first()->book->discont_global / 100)) * $ordersAll->purchase->qty + $ordersAll->purchase->magazin->price * $ordersAll->purchase->qty_m;


                            }

                                elseif($ordersAll->purchase->magazin->discont_privat != 0) 

                                {//

                                    $summa += ($ordersAll->purchase->magazin->price - ($ordersAll->purchase->magazin->price * $ordersAll->purchase->magazin->discont_global / 100)) * $ordersAll->purchase->qty_m + $purchase->first()->book->price  * $ordersAll->purchase->qty;

                                }

                            $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $ordersAll->purchase->first()->book->discont_global / 100)) * $ordersAll->purchase->qty + ($ordersAll->purchase->magazin->price - ($ordersAll->purchase->magazin->price * $ordersAll->purchase->magazin->discont_global / 100)) * $ordersAll->purchase->qty_m;

                        //
                        } elseif($ordersAll->purchase->first()->book->author->status_discont_id == 1 && $ordersAll->purchase->magazin->author->status_discont_id == 1)

                            {//

                                if($ordersAll->purchase->first()->book->author->status_discont_id == 1) 

                                {//
                                    $summa += ($ordersAll->purchase->first()->book->price - ($purchase->first()->book->price * $ordersAll->purchase->first()->book->author->discont_id / 100)) * $ordersAll->purchase->qty + $purchase->magazin->price * $ordersAll->purchase->qty_m;

                                }
                                    elseif($ordersAll->purchase->magazin->author->status_discont_id == 1) 

                                    {//

                                        $summa += ($ordersAll->purchase->magazin->price - ($ordersAll->purchase->magazin->price * $ordersAll->purchase->magazin->author->discont_id / 100)) * $ordersAll->purchase->qty_m + $ordersAll->purchase->first()->book->price  * $ordersAll->purchase->qty;

                                    }

                                $summa += ($ordersAll->purchase->first()->book->price - ($ordersAll->purchase->first()->book->price * $ordersAll->purchase->first()->book->author->discont_id / 100)) * $ordersAll->purchase->qty + ($ordersAll->purchase->magazin->price - ($ordersAll->purchase->magazin->price * $ordersAll->purchase->magazin->author->discont_id / 100)) * $ordersAll->purchase->qty_m;

                            //    
                            } else 

                                    {//

                                    $summa += $ordersAll->purchase->first()->book->price  * $purchase->qty + $ordersAll->purchase->magazin->price * $purchase->qty_m;

                                    }
                }
            }     

        }
        return $summa;

    }
    //{{$purchase->getSum()}} ::where(status_bought == 1)
    // public function getSum($summa)
    // {
    //     if($summa != null)
    //     {
    //         $this->sum = getSumma($summa);
    //         $this->save();
    //     }
    // }

    // public function getQuantitySum($sumQty, $sumQty_m)
    // {
    //     $sumQty = 0;          
    //     foreach($purchases as $purchase)
    //     {

    //         if($purchase->status_bought == 1)
    //         {
    //                     $sumQty = ($sumQty += $purchase->qty) + ($sumQty_m += $purchase->qty_m);
    //         }

    //     }
    // }


    // public function getQuantity()
    // {
    //     $sumQty = 0;
                          
    //     foreach($purchases as $purchase)
    //     {

    //         if($purchase->status_bought == 1)
    //         {
    //                     $sumQty += $purchase->qty;
    //         }

    //     }
    // }    

    // public function getQuantity_m()
    // {
    //     $sumQty_m = 0;
                          
    //     foreach($purchases as $purchase)
    //     {

    //         if($purchase->status_bought == 1)
    //         {
    //                     $sumQty_m += $purchase->qty_m;
    //         }

    //     }
    // }     
}
