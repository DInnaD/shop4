@if(Auth::check())
                   @if($purchase->magazin->sub_price != 0)
                    <td>0</td>
                    <td>{{$purchase->magazin->sub_price}}</td>
                    @else 
                      @if($magazin->discont_privat != 0 && $magazin->author->status_discont_id == 1)
                        @if($magazin->discont_global >= $magazin->author->discont_id)
                        <td>{{$magazin->discont_global}}</td>
                        <td>{{$magazin->price - ($magazin->price * $magazin->discont_global / 100)}}</td>
                        @else
                        <td>{{$magazin->author->discont_id}}</td>
                        <td>{{$magazin->price - ($magazin->price * $magazin->author->discont_id / 100)}}</td>
                        @endif
                      @elseif($magazin->discont_privat != 0)
                      <td>{{$magazin->discont_global}}</td>
                      <td>{{$magazin->price - ($magazin->price * $magazin->discont_global / 100)}}</td>
                      @elseif($magazin->author->status_discont_id == 1)
                      <td>{{$magazin->author->discont_id}}</td>
                      <td>{{$magazin->price - ($magazin->price * $magazin->author->discont_id / 100)}}</td>
                      @else
                      <td>0</td>
                      <td>{{$magazin->price}}</td>
                      @endif
                    @endif  
                  @else
                      @if($magazin->discont_privat != 0)
                      <td>{{$magazin->discont_global}}</td>
                      <td>{{$magazin->price - ($magazin->price * $magazin->discont_global / 100)}}</td>
                      @else
                      <td>0</td>
                      <td>{{$magazin->price}}</td>
                      @endif
                  @endif		