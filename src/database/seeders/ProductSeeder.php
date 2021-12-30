<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::factory(10)->create()->each(function ($product_category) {
            Product::factory(50)->create(['product_category_id' => $product_category->id])->each(function ($product) {
                ProductPrice::factory(1)->create(['product_id' => $product->id]);
            });
        });
    }
}
