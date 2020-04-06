<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($category)
    {
        DB::table('categories')->insert([
            'categoryName' => $category,
        ]);
    }
}
