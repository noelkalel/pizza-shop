@extends('layouts.app')

@section('title', ' - ' . $pizza->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $pizza->name }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <a href="{{ asset('/images/' . $pizza->image) }}">
                                    <img class="card-img-top" 
                                        src="{{ asset('/images/' . $pizza->image) }}" 
                                        alt="{{ $pizza->image }}" 
                                        height="200">
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf

                                <h5 class="card-title mb-3">
                                    {{ $pizza->name }}
                                </h5>
                                <p class="mb-3">
                                    {{ $pizza->description }}
                                </p>
                                <p class="mb-5">
                                    &euro;{{ \Str::formatPrice($pizza->price) }} / 
                                    ${{ \Str::formatPrice($pizza->dollarCurrency()) }}
                                </p>
                                <p>
                                    <input type="hidden" name="id" value="{{ $pizza->id }}">
                                    <input type="hidden" name="name" value="{{ $pizza->name }}">
                                    <input type="hidden" name="price" value="{{ $pizza->price }}">

                                    <button type="submit" class="btn btn-primary mt-3 float-right">
                                        Add To Cart
                                    </button>
                                </p>            
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
