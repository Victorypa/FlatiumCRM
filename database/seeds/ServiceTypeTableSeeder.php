<?php

use Illuminate\Database\Seeder;
use App\Models\Services\ServiceType;

class ServiceTypeTableSeeder extends Seeder
{
    public function run()
    {
        $service_types = [
            [
                'name' => 'Пол'
            ],

            [
                'name' => 'Стены'
            ],

            [
                'name' => 'Потолок'
            ],

            [
                'name' => 'Сантехнические работы'
            ],

            [
                'name' => 'Электрические работы'
            ]
        ];

        foreach ($service_types as $service_type) {
            ServiceType::create($service_type);
        }
    }
}
