<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::inRandomOrder()->first();
        $product_price = $product->product_prices->first();

        return [
            'product_id' => $product->id,
            'amount' => $product_price->price,
            'status' => 'enabled',
        ];
    }
}
