<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Materials\Material;

class UpdateMaterial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = public_path() . "/files/materials/prices.json";

        $materials = json_decode(file_get_contents($path), true);

        foreach ($materials as $material) {
            if (array_key_exists('number', $material)) {
                if ($currentMaterial = Material::where('number', $material['number'])->first()) {
                    $currentMaterial->update([
                        'price' => $currentMaterial['price']
                    ]);
                }
            }
            // if ($material['number']) {
            //     dump($material);
            // }

        }
    }
}
