@extends('layouts.app')

@section('title', '- Order History')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-body">
                @include('layouts.flash')

                <form action="{{ route('order.store') }}" method="post">
                    @csrf

                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email address">
                    
                    <button class="btn btn-primary btn-sm mt-3 btn-block">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
