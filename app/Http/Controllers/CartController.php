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
            $orders = \DB::table('orders')->select('ordered_products.orderedProduct', 'ordered_products.orderedAmount', 'orders.orderedPrice')->join('ordered_products', 'ordered_products.orderID', '=', 'orders.orderID')->where('orders.orderedUser', '=', $request->session()->get('customer')['name'])->get();
            $orderedPrices = \DB::table('orders')->select('orderedPrice')->where('orderedUser', '=', $request->session()->get('customer')['name'])->get();
            for ($i=0; $i < count($orderedPrices); $i++) {
                if(!isset($orderedPrices[$i]->orders)){
                    $orderedPrices[$i]->orders = array();
                }
                $selectedOrders = [];
                for ($x=0; $x < count($orders); $x++) {
                    if($orders[$x]->orderedPrice === $orderedPrices[$i]->orderedPrice){
                        array_push($selectedOrders, $orders[$x]);
                    }
                }
                array_push($orderedPrices[$i]->orders, $selectedOrders);
            }
            $request->session()->put('orders', $orderedPrices);
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

    public function placeOrder(Request $request){
        if($request->session()->has('customer')){
            if(count($request->session()->get('cart')) > 0){
                $inserted = \DB::table('orders')->insertGetId(['orderedUser'=>$request->session()->get('customer')['name'], 'orderedPrice'=>$request->session()->get('cartCost')]);
                for ($i=0; $i < count($request->session()->get('cart')); $i++) {
                    \DB::table('ordered_products')->insert(['orderedProduct'=>$request->session()->get('cart')[$i]->productName,'orderedAmount'=>$request->session()->get('cart')[$i]->amount,'orderID'=>$inserted]);
                }
                $this->createCart($request);
                return redirect('/');
            }
            else{
                return redirect('/');
            }
        }
        else{
            return redirect('login');;
        }
    }
}
