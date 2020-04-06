<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

class ProductsController extends Controller
{
    public function getProducts(){
        $products = \DB::table('products')->select('productName', 'productPrice', 'productCategory')->get();
        CartController::$availableProducts = $products;
    }
}
