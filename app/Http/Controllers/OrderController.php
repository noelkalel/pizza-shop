<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order');    
    }

    public function store()
    {
        $this->validate(request(),[
            'email' => 'required'
        ]);

        $orders = Order::where('email', request('email'))->get(); 

        return view('order-history', compact('orders'));   
    }
}
