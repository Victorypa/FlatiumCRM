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
            'isAdmin' => true,
            'phone' => '89052137085'
        ]);

        $user2 = User::create([
            'name' => 'Anna',
            'email' => 'anna.kudelya@flatium.ru',
            'password' => bcrypt('secret'),
            'isAdmin' => true
        ]);

        $user3 = User::create([
            'name' => 'Павел Старинцев',
            'email' => 'Pavel.Starintcev@flatium.ru',
            'password' => bcrypt('secret1'),
            'isAdmin' => false
        ]);

        $user4 = User::create([
            'name' => 'Дмитрий Юрин',
            'email' => 'dmitry.yurin@flatium.ru',
            'password' => bcrypt('secret2'),
            'isAdmin' => false
        ]);

        $user5 = User::create([
            'name' => 'Дмитрий Березин',
            'email' => 'berezin.super@yandex.ru',
            'password' => bcrypt('secret3'),
            'isAdmin' => false
        ]);

        $user1->roles()->syncWithoutDetaching([1]);
        $user2->roles()->syncWithoutDetaching([1]);
    }
}
