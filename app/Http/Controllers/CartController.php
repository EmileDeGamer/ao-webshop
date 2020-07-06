<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cart;

class CartController extends Controller
{
    public function addProductToCart(Request $request){
        $user = new User();
        $cartItems = $user->getCart($request);
        $cart = new Cart($request);
        $product = $cart->getSpecificProduct($request->input('productName'));
        $product->amount = $request->input('productAmount');
        $cartWithNewProducts = $cart->addProduct($product, $cartItems);
        $cart->saveCart($request, $cartWithNewProducts);
        return redirect('/');
    }

    public function removeProductFromCart(Request $request){
        $user = new User();
        $cartItems = $user->getCart($request);
        $cart = new Cart($request);
        $product = $cart->getSpecificProduct($request->input('productName'), $cart);
        $cartWithNewProducts = $cart->removeProduct($product, $cartItems);
        $cart->saveCart($request, $cartWithNewProducts);
        return back();
    }

    public function editProduct(Request $request){
        $user = new User();
        $cartItems = $user->getCart($request);
        $cart = new Cart($request);
        $product = $cart->getSpecificProduct($request->input('productName'), $cart);
        $product->amount = $request->input('productAmount');
        $cartWithNewProducts = $cart->editProduct($product, $cartItems);
        $cart->saveCart($request, $cartWithNewProducts);
        return back();
    }

    public function placeOrder(Request $request){
        if(count($request->session()->get('cart')->products) > 0){
            $order = new \App\Order;
            $insertedID = $order->createOrderAndGetID($request);
            for ($i=0; $i < count($request->session()->get('cart')->products); $i++) {
                $order->addOrderedProduct($request, $insertedID, $i);
            }
            $request->session()->forget('cart');
            $user = new User();
            $user->getCart($request);
            CartController::getOrders($request);
            return redirect('/');
        }
        else{
            return redirect('/');
        }
    }

    public static function getOrders(Request $request){
        $order = new \App\Order;
        $orders = $order->getOrdersByName($request);
        $orderedPrices = $order->getOrderPricesByUser($request);
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
}
