<?php

namespace App\Http\Controllers;

use App\Pizza;
use Illuminate\Http\Request;

class PizzasController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::latest()->get();
        
        return view('pizzas.index', compact('pizzas'));      
    }

    public function show(Pizza $pizza)
    {
        return view('pizzas.show', compact('pizza'));
    }
}
