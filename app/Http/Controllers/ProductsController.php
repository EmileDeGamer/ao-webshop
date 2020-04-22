<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProductsController extends Controller
{
    public function getProductsAndCategories(Request $request){
        $categories = \DB::table('categories')->select('categoryName')->get();
        $products = \DB::table('products')->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->get();
        for ($i=0; $i < count($products); $i++) {
            $products[$i]->productCategory = $products[$i]->categoryName;
            unset($products[$i]->categoryName);
        }
        $user = new User();
        $user->getCart($request);
        return view('index', ['categories'=>$categories,'products'=>$products]);
    }


    public function showProduct(Request $request){
        $productName = $request->input('productName');
        $product = \DB::table('products')->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->where('products.productName', '=', $productName)->get();
        $product[0]->productCategory = $product[0]->categoryName;
        unset($product[0]->categoryName);
        return view('product', ['product'=>$product[0]]);
    }
}
