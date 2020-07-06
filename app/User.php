<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;
use Illuminate\Http\Request;
use App\Product;

class User extends Model
{
    protected $table = 'users';
    
    public function getCart(Request $request){
        $cart = new Cart($request);
        $cart = $cart->getCart($request);
        return $cart;
    }

    public function createNewUser(Request $request, $hash){
        \DB::table($this->table)->insert(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'password'=>$hash]);
    }

    public function getUser(Request $request){
        return \DB::table($this->table)->select('name', 'email', 'password')->where('email' , '=', $request->input('email'))->first();
    }
}
