$sumQty = 0;          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
            {
                        $sumQty = ($sumQty += $purchase->qty) + ($sumQty_m += $purchase->qty_m);
            }

        }
    }