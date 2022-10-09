<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory([
            'email' => 'pedro.lucaswpl@gmail.com',
            'name' => 'Pedro Lucas',
            'password' => '123456',
            'password_confirmation' => '123456',
        ])
            ->count(1)
            ->create();
    }
}
