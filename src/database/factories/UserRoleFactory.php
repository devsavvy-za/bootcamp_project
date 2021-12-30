<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = Str::upper($this->faker->catchPhrase());

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => 'enabled',
        ];
    }
}
