<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand = $this->faker->numberBetween(0, 1000);
        $cancelled_at = ($rand <= 300) ? $this->faker->dateTimeBetween('-2 years', 'now') : null;
        $paid_at = ($rand > 300 && $rand <= 600) ? $this->faker->dateTimeBetween('-2 years', 'now') : null;
        $user = User::whereHas('user_role', function($query){
            $query->where('slug', 'customer');
        })->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'date' => $this->faker->date(date("Y-m-d", strtotime("-6 months")), 'now'),
            'cancelled_at' => $cancelled_at,
            'paid_at' => $paid_at,
            'status' => 'enabled',
        ];
    }
}
