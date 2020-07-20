@extends('layouts.app')

@section('title', '- Checkout')

@section('stripe-js')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('layouts.flash')

            <div class="card">
                <div class="card-header">Checkout</div>

                <div class="card-body mt-3 pt-3">
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <form action="{{ route('checkout.store') }}" method="post" id="payment-form">
                                @csrf

                                <div class="form-group">
                                    <label for="name" class="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" >
                                </div>

                                <div class="form-group">
                                    <label for="email" class="">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" >
                                </div>

                                <div class="form-group">
                                    <label for="address" class="">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" >
                                </div>

                                <h4 class="mt-4 mb-3">Payment Details</h4>

                                <div class="form-group">
                                    <label for="name_on_card">Name on Card</label>
                                    <input type="text" class="form-control" id="name_on_card" name="name_on_card" >
                                </div>
                                    <div id="card-element" >
                                    
                                    </div>
                                <div id="card-errors" role="alert"></div>

                                <button class="btn btn-primary btn-block mt-3" type="submit" id="complete-order">
                                    Complete Order
                                </button>
                            </form>
                        </div>

                        <div class="col-md-4 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Your cart</span>
                                <span class="badge badge-secondary badge-pill">{{ Cart::count() }}</span>
                            </h4>

                            <ul class="list-group mb-3 z-depth-1">
                                @foreach(Cart::content() as $item)
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">
                                                {{ $item->model->name }} &nbsp; x{{ $item->qty }} 
                                            </h6>
                                            <small class="text-muted">
                                                {{ strtolower($item->model->description) }}
                                            </small>
                                        </div>
                                        <span class="text-muted ml-1">
                                            &euro;{{ \Str::formatPrice($item->subtotal) }}/${{ \Str::formatPrice($item->qty * $item->model->dollarCurrency()) }}
                                        </span>
                                    </li>
                                @endforeach
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <strong>
                                        &euro;{{ \Str::formatPrice(Cart::subtotal()) }} /
                                        ${{ \Str::formatPrice(Cart::dollarSubtotal()) }}
                                    </strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tax (10%)</span>
                                    <strong>
                                        &euro;{{ \Str::formatPrice(Cart::tax()) }} /
                                        ${{ \Str::formatPrice(Cart::dollarTax()) }}
                                    </strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Total</strong>
                                    <strong>
                                        &euro; {{ \Str::formatPrice(Cart::total()) }} /
                                        ${{ \Str::formatPrice(Cart::dollarTotal()) }} 
                                    </strong>
                                </li>
                                <small class="text-muted mt-1">
                                    You will be charged in &euro; currency.
                                </small><br>
                            </ul>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('stripe')
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');

            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
            event.preventDefault();

            document.getElementById('complete-order').disabled = true;

            var options = {
                name: document.getElementById('name_on_card').value,
                address_line1: document.getElementById('address').value
            }

            stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;

                    document.getElementById('complete-order').disabled = false;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>
@endsection

<style>
    .StripeElement {
        background-color: white;
        padding: 10px 10px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        height: 40px;
        border-radius: 4px;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
