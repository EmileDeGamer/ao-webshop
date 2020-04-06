<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategory($product){
        $category = \DB::table('products')->select('categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->where('products.productName' , '=', $product->name);
        return view('categories', $category);
    }

    public function getCategoriesAndProducts(){
        $categories = \DB::table('categories')->select('categoryName')->get();
        $products = \DB::table('products')->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->get();
        for ($i=0; $i < count($products); $i++) {
            $products[$i]->productCategory = $products[$i]->categoryName;
            unset($products[$i]->categoryName);
        }
        return view('categories', ['categories'=>$categories,'products'=>$products]);
    }
}
