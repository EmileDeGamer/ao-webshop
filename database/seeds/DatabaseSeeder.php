<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['eten', 'drinken', 'groente', 'fruit', 'extraatje'];
        for ($i=0; $i < 150; $i++) {
            $this->call(ProductsSeeder::class);
        }

        for ($i=0; $i < count($categories); $i++) {
            $this->call(CategorySeeder::class, $categories[$i]);
        }
    }

    public function call($class, $extra = null){
        $this->resolve($class)->run($extra);

        if(isset($this->command)){
            $this->command->getOutput()->writeln("<info>Seeded:</info> $class");
        }
    }
}
