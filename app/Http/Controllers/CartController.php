<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {   
        return view('cart.index');    
    }

    public function store(Request $request)
    {
        $cart = Cart::add(
            request('id'), 
            request('name'), 
            1, 
            request('price')
        )->associate('App\Pizza');

        return redirect()->route('cart.index')->withSuccess('Item was added to your cart.');   
    }

    public function update(Request $request, $id)
    { 
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            \Session::flash('errors', collect(['Quantity must be between 1 and 5.']));

            return back();
        }

        Cart::update($id, request('quantity'));

        \Session::flash('success', 'Quantity was updated successfully');

        return response()->json(['success' => true]);   
    }

    public function destroy($id)
    {
        Cart::remove($id);

        return back()->withSuccess('Item removed.');
    }
}
