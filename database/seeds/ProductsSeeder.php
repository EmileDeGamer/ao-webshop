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
        DB::table('products')->insert([
            'productName' => Str::random(10),
            'productPrice' => rand(5, 15),
            'productCategory' => Str::random(10),
        ]);
    }
}
