<?php

namespace App\Console\Commands;

use App\ServiceIdQuantity;
use App\Models\Materials\Material;
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
