<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function getAvailableProducts(){
        $products = \DB::table($this->table)->select('productName', 'productPrice', 'productCategory')->get();
        for ($i=0; $i < count($products); $i++) {
            $products[$i]->amount = 0;
        }
        return $products;
    }

    public function getProduct($productName){
        return \DB::table($this->table)->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join('categories', 'products.productCategory', '=', 'categories.categoryID')->where('products.productName', '=', $productName)->get();
    }

    public function getProductsWithCategoryNames(){
        $category = new \App\Category;
        return \DB::table($this->table)->select('products.productName','products.productPrice','products.productCategory','categories.categoryName')->join($category->getCategoryTable(), 'products.productCategory', '=', 'categories.categoryID')->get();
    }
}
