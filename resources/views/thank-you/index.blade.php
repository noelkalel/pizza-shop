@extends('layouts.app')

@section('title', '- Thank You')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 text-center">
            @include('layouts.flash')  
                 
            @auth
                <p>
                    Check your order history "<a href="{{ route('home') }}">here</a>"
                </p>
            @endauth

            <p>
                <a href="{{ route('pizzas.index') }}" class="btn btn-primary btn-sm">
                    Home Page
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
