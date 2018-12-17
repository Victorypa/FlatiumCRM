<?php

use Illuminate\Database\Seeder;
use App\Models\Personal\Manager;

class ManagerTableSeeder extends Seeder
{
    public function run()
    {
        $managers = [
            [
                'name' => 'Елизавета Васильева',
                'phone' => '8-931-376-81-41'
            ]
        ];

        foreach ($managers as $manager) {
            Manager::create($manager);
        }
    }
}
