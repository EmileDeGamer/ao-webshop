<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ProductsController;

class CartController extends Controller
{
    static $availableProducts = [];

    public function createCart(Request $request){
        if($request->session()->has('customer')){
            $request->session()->put('cart', []);
            $request->session()->put('cartCost', 0);
        }
        else{
            return redirect('login');
        }
    }

    public function addProductToCart(Request $request){
        if($request->session()->has('customer')){
            $productsController = new ProductsController();
            $productsController->getProducts($request);
            for ($i=0; $i < count(CartController::$availableProducts); $i++) {
                if(CartController::$availableProducts[$i]->productName === $request->input('productName')){
                    $product = CartController::$availableProducts[$i];
                }
            }
            $product->amount = $request->input('productAmount');
            $products = $request->session()->get('cart');
            array_push($products, $product);
            $request->session()->put('cart', $products);
            $this->calculateCartValue($request);
            return redirect('/');
            var_dump('?');
        }
        else{
            return redirect('login');;
        }
    }

    public function calculateCartValue(Request $request){
        if($request->session()->has('customer')){
            $products = $request->session()->get('cart');
            $cost = 0;
            for ($i=0; $i < count($products); $i++) {
                for ($x=0; $x < $products[$i]->amount; $x++) {
                    $cost += $products[$i]->productPrice;
                }
            }
            $request->session()->put('cartCost', $cost);
        }
        else{
            return redirect('login');;
        }
    }

    public function removeProductFromCart(Request $request){
        if($request->session()->has('customer')){
            $products = $request->session()->get('cart');
            for ($i=0; $i < count($products); $i++) {
                if($products[$i]->productName === $request->input('productName')){
                    array_splice($products, $i, 1);
                }
            }
            $request->session()->put('cart', $products);
            $this->calculateCartValue($request);
            return back();
        }
        else{
            return redirect('login');;
        }
    }

    public function editProductAmountInCart(Request $request){
        if($request->session()->has('customer')){
            $products = $request->session()->get('cart');
            for ($i=0; $i < count($products); $i++) {
                if($products[$i]->productName === $request->input('productName')){
                    $products[$i]->amount = $request->input('productAmount');
                }
            }
            $request->session()->put('cart', $products);
            $this->calculateCartValue($request);
            return back();
        }
        else{
            return redirect('login');;
        }
    }

    public function showCart(Request $request){
        if($request->session()->has('customer')){
            return view('cart');
        }
        else{
            return redirect('login');;
        }
    }
}
