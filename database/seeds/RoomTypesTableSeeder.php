<?php

use App\Models\Types\RoomType;
use Illuminate\Database\Seeder;

class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $room_types = [
            [
                'type' => 'Комната'
            ],

            [
                'type' => 'Электричество'
            ],

            [
                'type' => 'Сантехника'
            ],

            [
                'type' => 'Рекомендуемые'
            ]
        ];

        foreach ($room_types as $type) {
            RoomType::create($type);
        }
    }
}
