<h1>Thankyou for your time {{ $sub->author->name }}.</h1>
<div>
  Order Number: {{ $sub->id }}	
  Price: {{ $sub->sum }}
  Books Quantity: {{ $sub->qty }}
  Magazines Quantity: {{ $sub->qty_m }}
</div>
