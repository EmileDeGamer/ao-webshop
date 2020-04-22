<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;
use Illuminate\Http\Request;
use App\Product;

class User extends Model
{
    public function getCart(Request $request){
        $cart = new Cart($request);
        $cart = $cart->getCart($request);
        return $cart;
    }

    public function getUser(Request $request){
        return $request->session()->get('user');
    }
}
