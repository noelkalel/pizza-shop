<?php

namespace App\Http\Controllers;

use App\Order;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');    
    }

    public function store(CheckoutRequest $request)
    {
        $contents = Cart::content()->map(function ($item) {
            return $item->model->slug . ', ' . $item->qty;
        })->values()->toJson();

        try {
            $charge = Stripe::charges()->create([
                'amount' => Cart::total(),
                'currency' => 'EUR',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count()
                ],
            ]);

            $order = Order::create([
                'user_id' => auth()->user()->id ?? null,
                'name'    => request('name'),
                'email'   => request('email'),
                'address' => request('address'),
            ]);

            foreach(Cart::content() as $item){
                $order->pizzas()->save($order, [
                    'pizza_id' => $item->model->id,
                    'quantity' => $item->qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            event(new OrderCreated($order));

            Cart::instance('default')->destroy();

            \Session::flash('success', '
                Your Order has been completed! 
                Confirmation email was sent on your email address. 
                Thank You. :)');

            return redirect()->route('thank-you');
        } catch (CardErrorException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        } 
    }

    public function thankYou()
    {
        if(!session()->has('success')){
            return redirect()->route('pizzas.index');
        }

        return view('thank-you.index');
    }
}
