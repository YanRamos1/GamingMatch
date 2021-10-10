<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles[] = [
            'id' => 1,
            'name' => 'ADMIN'
        ];
        $roles[] = [
            'id' => 2,
            'name' =>  'USER',
        ];
        Role::insert($roles);
    }
}
