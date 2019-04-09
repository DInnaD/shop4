$sumQty = 0;
                          
        foreach($purchases as $purchase)
        {

            if($purchase->status_bought == 1)
            {
                        $sumQty += $purchase->qty;
            }

        }