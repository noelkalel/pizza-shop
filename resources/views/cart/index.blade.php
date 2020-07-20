@extends('layouts.app')

@section('title', '- Cart')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @include('layouts.flash')
                
                @if(Cart::count() > 0)
                    <h4>
                        {{ Cart::count() }} {{ Cart::count() == 1 ? 'Item' : 'Items' }} in your cart!
                    </h4><br>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Item</th>
                                            <th></th>
                                            <th scope="col" class="text-center">Quantity</th>
                                            <th scope="col" class="text-right">Price</th>
                                            <th></th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach(Cart::content() as $item)
                                        <tr>
                                            <th></th>
                                            <td>
                                                <a href="{{ asset('/images/' . $item->model->image) }}">
                                                    <img 
                                                        src="{{ asset('/images/' . $item->model->image) }}" style="width: 50px;"> 
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('pizzas.show', $item->model->slug) }}">
                                                    {{ $item->model->name }}
                                                </a>
                                            </td>
                                            <td></td>
                                            <td>  
                                                <select class="quantity form-control" data-id="{{ $item->rowId }}">
                                                    @for ($i = 1; $i < 5 + 1 ; $i++)
                                                        <option {{ $item->qty == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td class="text-right">
                                                &euro;{{ \Str::formatPrice($item->subtotal) }} / 
                                                ${{ \Str::formatPrice($item->qty * $item->model->dollarCurrency()) }}
                                            </td>
                                            <td class="text-right">
                                            <form 
                                                action="{{ route('cart.destroy', $item->rowId) }}" 
                                                method="post">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> 
                                                </button> 
                                            </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                Subtotal
                                            </td>
                                            <td class="text-right">
                                                &euro;{{ \Str::formatPrice(Cart::subtotal()) }} / 
                                                ${{ \Str::formatPrice(Cart::dollarSubtotal()) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                Tax (10%)
                                            </td>
                                            <td class="text-right">
                                                &euro;{{ \Str::formatPrice(Cart::tax()) }} /
                                                ${{ \Str::formatPrice(Cart::dollarTax()) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <strong>Total</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>
                                                    &euro; {{ \Str::formatPrice(Cart::total()) }} /
                                                    ${{ \Str::formatPrice(Cart::dollarTotal()) }} 
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <a href="{{ route('pizzas.index') }}" class="btn btn-block btn-light">
                                        Continue Shopping
                                    </a>
                                </div>
                                <div class="col-sm-12 col-md-6 text-right">
                                    <a href="{{ route('checkout.index') }}" class="btn btn-block btn-primary">
                                        Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center">No Items in cart</p>

                    <p class="text-center">
                        <a href="{{ route('pizzas.index') }}" class="btn btn-primary btn-sm">
                            Continue Shopping
                        </a>
                    </p>
                @endif                
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value
                    })
                    .then(function (response){
                        window.location.href = '{{ route('cart.index') }}'
                    })
                    .catch(function (error){
                        window.location.href = '{{ route('cart.index') }}'
                    });
                })
            })
        })();
    </script>
@endsection