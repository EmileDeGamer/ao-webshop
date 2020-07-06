<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Order extends Model
{
    protected $table = 'orders';
    
    public function getOrdersByName(Request $request){
        return \DB::table($this->table)->select('ordered_products.orderedProduct', 'ordered_products.orderedAmount', 'orders.orderedPrice')->join('ordered_products', 'ordered_products.orderID', '=', 'orders.orderID')->where('orders.orderedUser', '=', $request->session()->get('user')['name'])->get();
    }
    
    public function getOrderPricesByUser(Request $request){
        return \DB::table($this->table)->select('orderedPrice')->where('orderedUser', '=', $request->session()->get('user')['name'])->get();
    }

    public function createOrderAndGetID(Request $request){
        return \DB::table($this->table)->insertGetId(['orderedUser'=>$request->session()->get('user')['name'], 'orderedPrice'=>$request->session()->get('cart')->price]);
    }

    public function addOrderedProduct(Request $request, $insertedID, $i){
        \DB::table('ordered_products')->insert(['orderedProduct'=>$request->session()->get('cart')->products[$i]->productName,'orderedAmount'=>$request->session()->get('cart')->products[$i]->amount,'orderID'=>$insertedID]);
    }
}
