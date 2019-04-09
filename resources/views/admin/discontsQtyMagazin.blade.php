{{--@if($purchase->book_id != 0)@else($purchase->magazin_id != 0)@endif--}}
@if($purchase->magazin->status_sub_price != 0)
  <td>0</td>
  <td>{{$purchase->magazin->price * $purchase->magazin->sub_price / 100)) * 12}}</td>
  @else
	@if($purchase->magazin->discont_privat != 0 && $purchase->magazin->author->status_discont_id == 1)
	  @if($purchase->magazin->discont_global >= $purchase->magazin->author->discont_id)
	  <td>{{$purchase->magazin->discont_global}}</td>
	  <td>{{($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m}}</td>
	  @else
	  <td>{{$purchase->magazin->author->discont_id}}</td>
	  <td>{{($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m}}</td>
	  @endif
	@elseif($purchase->magazin->discont_privat != 0)
	<td>{{$purchase->magazin->discont_global}}</td>
	<td>{{($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->discont_global / 100)) * $purchase->qty_m}}</td>
	@elseif($purchase->magazin->author->status_discont_id == 1)
	<td>{{$purchase->magazin->author->discont_id}}</td>
	<td>{{($purchase->magazin->price - ($purchase->magazin->price * $purchase->magazin->author->discont_id / 100)) * $purchase->qty_m}}</td>
	@else
	<td>0</td>
	<td>{{$purchase->magazin->price  * $purchase->qty_m}}</td>
	@endif
@endif	