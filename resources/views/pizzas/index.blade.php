@extends('layouts.app')

@section('title', '- Pizzas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Menu</div>

                <div class="card-body">
                    <div class="row">
                        @foreach($pizzas as $pizza)
                            <div class="col-sm-4">
                                <div class="card">
                                    <a href="{{ asset('/images/' . $pizza->image) }}">
                                        <img class="card-img-top" 
                                            src="{{ asset('/images/' . $pizza->image) }}" 
                                            alt="{{ $pizza->image }}" 
                                            height="200">
                                    </a>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $pizza->name }}</h5>
                                        <p class="card-text">{{ $pizza->description }}</p>

                                        <div class="d-flex">
                                            <div>
                                                &euro;{{ \Str::formatPrice($pizza->price) }} / 
                                                ${{ \Str::formatPrice($pizza->dollarCurrency()) }}
                                            </div>
                                            <a href="{{ route('pizzas.show', $pizza->slug) }}" class="btn btn-primary btn-sm ml-auto">
                                                Order
                                            </a>
                                        </div>
                                    </div>
                                </div><br>
                            </div>
                        @endforeach
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
