<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(50)->create()->each(function ($order) {
            OrderItem::factory(rand(1, 10))->create(['order_id' => $order->id]);
        });
    }
}
