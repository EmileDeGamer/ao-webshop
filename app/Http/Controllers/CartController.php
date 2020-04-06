<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ProductsController;

class CartController extends Controller
{
    static $availableProducts = [];

    public function createCart(Request $request){
        $productsController = new ProductsController();
        $productsController->getProducts();
        $request->session()->put('cart', []);
        $request->session()->put('cartCost', 0);
        return view('index');
    }

    public function addProductToCart(Request $request){
        $productsController = new ProductsController();
        $productsController->getProducts();
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
        return redirect('categories');
    }

    public function calculateCartValue(Request $request){
        $products = $request->session()->get('cart');
        $cost = 0;
        for ($i=0; $i < count($products); $i++) {
            for ($x=0; $x < $products[$i]->amount; $x++) {
                $cost += $products[$i]->productPrice;
            }
        }
        $request->session()->put('cartCost', $cost);
    }

    public function removeProductFromCart(Request $request){
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

    public function editProductAmountInCart($product, $amount = 1){
        $this->products[$product]->amount = $amount;
        $request->session()->put('cart', $this->products);
    }

    public function showCart(Request $request){
        return view('cart');
    }
}
