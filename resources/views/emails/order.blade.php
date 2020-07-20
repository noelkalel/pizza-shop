@component('mail::message')
    # Order Confirmation

    Your order was successfully received. You can expect your order in the next 30 minutes.


    Order Details:

@foreach ($order->pizzas as $pizza)
    Pizza Name: {{ $pizza->name }} 
    Quantity: {{ $pizza->pivot->quantity }}
    Price: €{{ \Str::formatPrice(Cart::total()) }}/${{ \Str::formatPrice(Cart::dollarTotal()) }}

@endforeach

    Yours,
    {{ config('app.name') }}
@endcomponent