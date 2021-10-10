<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin[] = [
            'id' => 1,
            'name' => 'Richard',
            'email' => 'richard@gmail.com',
            'password' => '$2y$10$Wjx53w/mLqvgblyQAmSOdOFmYaieHoxuaIDAbrBFJKsg2iuXCTszG',
            'remember_token' => null,
            'created_at' => now(),
            'created_at' => now(),
            'role_id' => 1,

        ];
        User::insert($admin);
    }
}
