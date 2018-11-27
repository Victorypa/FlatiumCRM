<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin'
            ],

            [
                'name' => 'user'
            ],

            [
                'name' => 'developer'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
