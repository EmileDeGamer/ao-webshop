<?php

namespace App;

use App\CartBase;
use Illuminate\Http\Request;

class Cart extends CartBase
{
    public function __construct(Request $request){
        $cart = $request->session()->get('cart');
        if(!isset($cart)){
            $cart = new \stdClass();
            $cart->products = [];
            $cart->price = 0;
            $request->session()->put('cart', $cart);
        }
        return $cart;
    }

    public function getTotalPrice($products){
        $price = 0;
        for ($i=0; $i < count($products); $i++) {
            $price += $products[$i]->productPrice * $products[$i]->amount;
        }
        return $price;
    }

    public function addProduct($product, $cart){
        for ($i=0; $i < count($cart->products); $i++) { 
            if($product->productName === $cart->products[$i]->productName){
                $cart->products[$i]->amount += $product->amount;
                $cart->price = $this->getTotalPrice($cart->products);
                return $cart;
            }
        }
        array_push($cart->products, $product);
        $cart->price = $this->getTotalPrice($cart->products);
        return $cart;
    }

    public function removeProduct($product, $cart){
        for ($i=0; $i < count($cart->products); $i++) {
            if($cart->products[$i]->productName === $product->productName){
                array_splice($cart->products, $i, 1);
            }
        }
        $cart->price = $this->getTotalPrice($cart->products);
        return $cart;
    }

    public function editProduct($product, $cart){
        for ($i=0; $i < count($cart->products); $i++) { 
            if($cart->products[$i]->productName === $product->productName){
                $cart->products[$i] = $product;
                break;
            }
        }
        $cart->price = $this->getTotalPrice($cart->products);
        return $cart;
    }

    public function getAvailableProducts(){
        $products = \DB::table('products')->select('productName', 'productPrice', 'productCategory')->get();
        for ($i=0; $i < count($products); $i++) {
            $products[$i]->amount = 0;
        }
        return $products;
    }

    public function getSpecificProduct($productName){
        $products = $this->getAvailableProducts();
        for ($i=0; $i < count($products); $i++) { 
            if($products[$i]->productName === $productName){
                return $products[$i];
            }
        }
        return false;
    }

    public function getCart(Request $request){
        return $request->session()->get('cart');
    }

    public function saveCart(Request $request, $cart){
        $request->session()->put('cart', $cart);
    }
}
