<?php

use App\Product;
use App\ProductVariation;
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
//        factory(\App\Category::class, 12)->create()->each(function ($category) {
//            for ($x = 0; $x < 12; $x++) {
//                $product = factory(Product::class)->make();
//                $category->products()->save($product);
//            }
//        });
//
//        Product::all()->each(function ($product) {
//            $product->variations()->save(factory(ProductVariation::class)->make());
//        });
//        factory(\App\Rating::class, 18)->create();
//
//        factory(\App\Sale::class, 20)->create();

        \App\User::create(['name'=>'root','email'=>'root@domain.com', 'password'=>bcrypt('123'), 'role'=>3]);
    }
}
