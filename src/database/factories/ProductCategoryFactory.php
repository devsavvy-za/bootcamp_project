<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = Str::title($this->faker->catchPhrase());

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => 'enabled',
        ];
    }
}
