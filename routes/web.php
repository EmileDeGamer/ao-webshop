<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Auth;
use App\Http\Middleware\NotAuth;

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



Route::middleware([Auth::class])->group(function(){
    Route::get('/', 'ProductsController@getProductsAndCategories');
    Route::get('/logout', 'UserController@logoutUser');
    Route::post('/showProduct', 'ProductsController@showProduct');
    Route::post('/addToCart', 'CartController@addProductToCart');
    Route::post('/deleteFromCart', 'CartController@removeProductFromCart');
    Route::get('/cart', function(){
        return view('cart');
    });
    Route::post('/editCart', 'CartController@editProduct');
    Route::post('/placeOrder', 'CartController@placeOrder');
});

Route::middleware([NotAuth::class])->group(function(){
    Route::get('/login', function(){
        return view('login');
    });

    Route::get('/register', function(){
        return view('register');
    });

    Route::post('/register', 'UserController@registerUser');
    Route::post('/login', 'UserController@loginUser');
});
