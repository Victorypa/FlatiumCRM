<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $user1 = User::create([
            'name' => 'Elijah',
            'email' => 'elijah@gmail.com',
            'password' => bcrypt('secret'),
            'isAdmin' => true
        ]);

        $user2 = User::create([
            'name' => 'Anna',
            'email' => 'anna.kudelya@flatium.ru',
            'password' => bcrypt('secret'),
            'isAdmin' => true
        ]);

        $user1->roles()->syncWithoutDetaching([1]);
        $user2->roles()->syncWithoutDetaching([1]);
    }
}
