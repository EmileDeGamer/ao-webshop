<?php

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

//Route::get('/', 'CartController@createCart');
Route::get('/', 'CategoryController@getCategoriesAndProducts');
Route::post('/showProduct', 'ProductsController@showProduct');
Route::post('/addToCart', 'CartController@addProductToCart');
Route::post('/deleteFromCart', 'CartController@removeProductFromCart');
Route::get('/cart', 'CartController@showCart');
Route::post('/editCart', 'CartController@editProductAmountInCart');
Route::get('/register', 'UserController@indexRegister');
Route::get('/login', 'UserController@indexLogin');
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::post('/placeOrder', 'CartController@placeOrder');
