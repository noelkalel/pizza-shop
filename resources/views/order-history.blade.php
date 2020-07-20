@extends('layouts.app')

@section('title', '- Order History')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if($orders->count() > 0)
            @foreach($orders as $order)
                <div class="col-md-10">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex">
                                <div>
                                    <strong>ID:</strong> {{ $order->id }}
                                </div>
                                <div class="ml-auto">
                                    <strong>Order Placed:</strong> {{ $order->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @foreach($order->pizzas as $pizza)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <a href="{{ asset('/images/' . $pizza->image) }}">
                                                <img class="card-img-top" 
                                                    src="{{ asset('/images/' . $pizza->image) }}" 
                                                    alt="{{ $pizza->image }}" 
                                                    height="200">
                                            </a>
                                        </div><br>
                                    </div>
                                    <div class="col-sm-6"> 
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Email:</span>
                                            <strong>
                                                {{ request('email') ? request('email') : auth()->user()->email }}
                                            </strong>
                                        </li> 
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Pizza name:</span>
                                            <strong>
                                                {{ $pizza->name }}
                                            </strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Quantity:</span>
                                            <strong>
                                                {{ $pizza->pivot->quantity }}
                                            </strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Price without tax:</span>
                                            <strong>
                                                &euro;{{ \Str::formatPrice($pizza->price) }} / 
                                                ${{ \Str::formatPrice($pizza->dollarCurrency()) }}
                                            </strong>
                                        </li>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-6">
                <div class="alert alert-danger text-center">
                    We cant find that email :( Try with another one...
                </div>

                <a href="{{ route('order.index') }}" class="btn btn-primary btn-sm btn-block">
                    Go Back
                </a>
            </div>
        @endif
    </div>
</div>
@endsection