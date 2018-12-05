<?php

namespace App\Console\Commands;

use App\Models\Materials\Material;
use App\ServiceIdQuantity;
// use App\Models\Materials\Material;
use Illuminate\Console\Command;

class MaterialQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:quantity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // foreach (Material::get() as $material) {
        //     if ($material->quantity !== null) {
        //         ServiceIdQuantity::create([
        //             'service_id' => $material->id,
        //             'quantity' => $material->quantity
        //         ]);
        //     }
        // }
        // Material::create([
        //     'material_unit_id' => 3,
        //     'name' => 'Гидроизоляционная мастика KIILTO Fiberpool 7 кг',
        //     'price' => 3060,
        //     'quantity' => 7,
        //     'univalence' => 437,
        //     'can_be_deleted' => true
        // ]);
        //
        // Material::create([
        //     'material_unit_id' => 3,
        //     'name' => 'Гидроизоляционная мастика KIILTO Fiberpool 14 кг',
        //     'price' => 5990,
        //     'quantity' => 14,
        //     'univalence' => 427,
        //     'can_be_deleted' => true
        // ]);

        // foreach (ServiceIdQuantity::get() as $item) {
        //     Material::where('id', $item->service_id)->update([
        //         'quantity' => $item->quantity
        //     ]);
        //     // if (Material::where('id', $item->service_id)->first()->quantity ) {
        //     //     // code...
        //     // }
        // }
    }
}
