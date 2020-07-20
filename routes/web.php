<?php

use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home',                     'HomeController@index')->name('home');

// Pizza Controller
Route::get('/',                         'PizzasController@index')->name('pizzas.index');
Route::get('/pizzas/{pizza:slug}',      'PizzasController@show')->name('pizzas.show');

// Cart Controller
Route::get('/cart',                     'CartController@index')->name('cart.index');
Route::post('/cart',                    'CartController@store')->name('cart.store');
Route::patch('/cart/{pizza}',           'CartController@update')->name('cart.update');
Route::delete('/cart/{pizza}',          'CartController@destroy')->name('cart.destroy');

// Checkout Controller
Route::get('/checkout',                 'CheckoutController@index')->name('checkout.index');
Route::post('/checkout',                'CheckoutController@store')->name('checkout.store');
Route::get('/thank-you',                'CheckoutController@thankYou')->name('thank-you');

// Order Controller
Route::get('/order',                    'OrderController@index')->name('order.index');
Route::post('/order',                   'OrderController@store')->name('order.store');