$summa = 0;

        foreach ($purchases as $purchase) {//place for future comments

            if($purchase->status_bought == 1)
            {

                if($purchase->magazin->sub_price != 0 && $purchase->magazin->qty_m == 1)
                {

                  $summa = $purchase->magazin->sub_price;

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