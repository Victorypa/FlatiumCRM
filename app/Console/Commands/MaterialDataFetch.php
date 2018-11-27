<?php

namespace App\Console\Commands;

use App\Models\Units\MaterialUnit;
use Illuminate\Console\Command;
use App\Models\Materials\Material;

class MaterialDataFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch material list from json file';

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
        $path = public_path() . "/files/materials/data.json";

        $materials = json_decode(file_get_contents($path), true);

        $this->saveMaterialUnits($materials);

        foreach ($materials as $material) {

            if (trim($material['unit']) === 'л.') {
                $this->saveMaterial($material, 1);
            }

            if (trim($material['unit']) === 'упак') {
                $this->saveMaterial($material, 2);
            };

            if (trim($material['unit']) === 'шт.') {
                $this->saveMaterial($material, 3);
            };

            if (trim($material['unit']) === 'шт') {
                $this->saveMaterial($material, 3);
            };

            if (trim($material['unit']) === 'кор') {
                $this->saveMaterial($material, 4);
            };

            if (trim($material['unit']) === 'рул') {
                $this->saveMaterial($material, 5);
            };

            if (trim($material['unit']) === 'меш.') {
                $this->saveMaterial($material, 6);
            };

            if (trim($material['unit']) === 'паллета') {
                $this->saveMaterial($material, 7);
            };

            if (trim($material['unit']) === 'пог. м') {
                $this->saveMaterial($material, 8);
            };

            if (trim($material['unit']) === 'бух.') {
                $this->saveMaterial($material, 9);
            };

            if (trim($material['unit']) === 'компл') {
                $this->saveMaterial($material, 10);
            };

            if (trim($material['unit']) === 'м2') {
                $this->saveMaterial($material, 11);
            };

            if (trim($material['unit']) === 'пар') {
                $this->saveMaterial($material, 12);
            }

            if (trim($material['unit']) === 'боб') {
                $this->saveMaterial($material, 13);
            }
    }
}

    protected function rebaseJsonFile()
    {
        $path = public_path() . "/files/materials/data.json";

        // decode json to associative array
        $json_arr = json_decode(file_get_contents($path), true);

        $arr_index = [];

        foreach ($json_arr as $key => $value) {
            if ($value['unit'] == "" || $value['name'] == "" || $value['price'] == "" || gettype($value['name']) === 'array') {
                $arr_index[] = $key;
            }
        }

        // delete data
        foreach ($arr_index as $i) {
            unset($json_arr[$i]);
        }

        // rebase array
        $json_arr = array_values($json_arr);

        // encode array to json and save to file
        file_put_contents($path, json_encode($json_arr));
    }

    protected function saveMaterial($material, $unit_id)
    {
        Material::create([
            'material_unit_id' => $unit_id,
            'name' => trim($material['name']),
            'price' => $material['price'],
            'number' => $material['number']
        ]);

    }

    protected function saveMaterialUnits($materials)
    {
        $units = [];

        foreach ($materials as $material) {
            array_push($units, trim($material['unit']));
        }

        $units = array_unique($units);

        if (($key = array_search('шт', $units)) !== false) {
            unset($units[$key]);
        }

        foreach ($units as $unit) {
            MaterialUnit::create([
                'name' => $unit
            ]);
        }
    }
}
