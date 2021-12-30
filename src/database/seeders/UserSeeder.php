<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::factory(1)->create(['title' => 'Admin', 'slug' => 'admin'])->each(function ($user_role) {
            $user_role->users()->saveMany(User::factory(3)->make());
        });

        UserRole::factory(1)->create(['title' => 'Customer', 'slug' => 'customer'])->each(function ($user_role) {
            $user_role->users()->saveMany(User::factory(30)->make());
        });
    }
}
