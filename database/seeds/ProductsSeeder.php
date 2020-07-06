<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Product::create([
            'productName' => Str::random(10),
            'productPrice' => rand(1, 150),
            'productCategory' => rand(1, 5)
        ]);
    }
}
