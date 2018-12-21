<?php

use App\Models\Units\Unit;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    public function run()
    {
        $units = [
            [
                'name' => 'кв. м'
            ],

            [
                'name' => 'м.п'
            ],

            [
                'name' => 'шт.'
            ],

            [
                'name' => 'изд.'
            ],

            [
                'name' => 'м.'
            ],

            [
                'name' => 'точ'
            ],

            [
                'name' => 'услуг'
            ]
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
