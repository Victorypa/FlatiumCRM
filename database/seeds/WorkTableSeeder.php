<?php

use App\Models\Work\Work;
use Illuminate\Database\Seeder;

class WorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $works = [
            [
                'name' => 'Демонтажные работы'
            ],

            [
                'name' => 'Возведение перегородок'
            ],

            [
                'name' => 'Устройство пола (черновые работы)'
            ],

            [
                'name' => 'Устройство финишного покрытия пола'
            ],

            [
                'name' => 'Отделка стен (черновая отделка)'
            ],

            [
                'name' => 'Финишное покрытие стен'
            ],

            [
                'name' => 'Устройство потолка (черновая отделка)'
            ],

            [
                'name' => 'Финишная отделка потолка'
            ],

            [
                'name' => 'Разводка сантехники'
            ],

            [
                'name' => 'Установка сантех приборов'
            ],

            [
                'name' => 'Разводка Электрике'
            ],

            [
                'name' => 'Установка электро приборов'
            ],
        ];

        foreach ($works as $work) {
            Work::create($work);
        }
    }
}
