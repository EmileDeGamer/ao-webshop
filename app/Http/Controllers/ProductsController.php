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

    public function showProduct(Request $request){
        $productName = $request->input('productName');
        //$product = \DB::table('products')->where('productName', '=', $productName)->get();
        $product = \DB::table('products')->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->where('products.productName', '=', $productName)->get();
        $product[0]->productCategory = $product[0]->categoryName;
        unset($product[0]->categoryName);
        return view('product', ['product'=>$product[0]]);
    }
}
