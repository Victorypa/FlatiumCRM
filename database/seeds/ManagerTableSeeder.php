<?php

use Illuminate\Database\Seeder;
use App\Models\Personal\Manager;

class ManagerTableSeeder extends Seeder
{
    public function run()
    {
        $managers = [
            [
                'name' => 'Дмитрий Щеблыкин',
                'phone' => '8-931-376-81-42'
            ],
            [
                'name' => 'Елизавета Васильева',
                'phone' => '8-931-376-81-41'
            ],
            [
                'name' => 'Илья Лысенко',
                'phone' => '8-931-376-81-34'
            ]
        ];

        foreach ($managers as $manager) {
            Manager::create($manager);
        }
    }
}
