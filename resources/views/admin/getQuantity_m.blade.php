$sumQty_m = 0;
                          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
            {
                        $sumQty_m += $purchase->qty_m;
            }

        }