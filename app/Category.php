<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function getCategories(){
        return \DB::table($this->table)->select('categoryName')->get();
    }

    public function getCategoryTable(){
        return $this->table;
    }
}
