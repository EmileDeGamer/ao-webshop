<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

class CategoryController extends Controller
{
    public function getCategoriesAndProducts(Request $request){
        if($request->session()->has('customer')){
            $categories = \DB::table('categories')->select('categoryName')->get();
            $products = \DB::table('products')->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->get();
            for ($i=0; $i < count($products); $i++) {
                $products[$i]->productCategory = $products[$i]->categoryName;
                unset($products[$i]->categoryName);
            }
            if(!$request->session()->has('cart')){
                $cartController = new CartController();
                $cartController->createCart($request);
            }
            return view('index', ['categories'=>$categories,'products'=>$products]);
        }
        else{
            return redirect('login');;
        }
    }
}
