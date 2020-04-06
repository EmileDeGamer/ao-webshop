<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

class ProductsController extends Controller
{
    public function getProducts(Request $request){
        if($request->session()->has('customer')){
            $products = \DB::table('products')->select('productName', 'productPrice', 'productCategory')->get();
            for ($i=0; $i < count($products); $i++) {
                $products[$i]->amount = 0;
            }
            CartController::$availableProducts = $products;
        }
        else{
            return redirect('login');
        }
    }

    public function showProduct(Request $request){
        if($request->session()->has('customer')){
            $productName = $request->input('productName');
            $product = \DB::table('products')->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->where('products.productName', '=', $productName)->get();
            $product[0]->productCategory = $product[0]->categoryName;
            unset($product[0]->categoryName);
            return view('product', ['product'=>$product[0]]);
        }
        else{
            return redirect('login');
        }
    }
}
