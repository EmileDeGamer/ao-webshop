<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class CartBase extends Model
{
    abstract protected function getTotalPrice($products);
    abstract protected function addProduct($product, $cart);
    abstract protected function removeProduct($product, $cart);
    abstract protected function editProduct($product, $cart);
}
