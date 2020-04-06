<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ProductsController;

class CartController extends Controller
{
    static $availableProducts = [];
    public $products = [];

    public function createCart(Request $request){
        $productsController = new ProductsController();
        $productsController->getProducts();
        $this->products = CartController::$availableProducts;
        $request->session()->put('cart', $this->products);
        return view('index');
    }

    public function addProductToCart($request, $product, $amount = 1){
        $product->amount = $amount;
        array_push($this->products, $product);
        $request->session()->put('cart', $this->products);
    }

    public function removeProductFromCart($product, $amount = 1){
        unset($this->products[$product]);
        $request->session()->put('cart', $this->products);
    }

    public function editProductAmountInCart($product, $amount = 1){
        $this->products[$product]->amount = $amount;
        $request->session()->put('cart', $this->products);
    }
}
