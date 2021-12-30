<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->randomFloat(2, 10, 100),
            'date_from' => $this->faker->date(date("Y-m-d", strtotime("-6 months")), 'now'),
            'status' => 'enabled',
        ];
    }
}
