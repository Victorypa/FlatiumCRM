<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Services\Service;
use App\Models\Services\ActualService;

class ServicesDataFetch extends Command
{
    protected $signature = 'service:data';

    protected $description = 'Fetch all services data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->floor_services();
        $this->wall_services();
        $this->ceiling_services();
        $this->plumbing_services();
        $this->electricity_services();

        $this->updateCanBeDiscountedColumn();
    }

    protected function floor_services()
    {
        $floor_path = public_path() . "/files/services/floor_services.json";
        $floor_arr = json_decode(file_get_contents($floor_path), true)['Sheet1'];
        foreach ($floor_arr as $service) {
            if (trim($service['unit']) === trim('кв. м')) {
                Service::create([
                    'service_type_id' => 1,
                    'unit_id' => 1,
                    'name' => $service['name'],
                    'price' => $service['price'],
                    'can_be_deleted' => false
                ]);
            }
            if (trim($service['unit']) === trim('м/п') || trim($service['unit']) === trim('м/п.')) {
                Service::create([
                    'service_type_id' => 1,
                    'unit_id' => 2,
                    'name' => $service['name'],
                    'price' => $service['price'],
                    'can_be_deleted' => false
                ]);
            }

        }
    }

    protected function wall_services()
    {
        $wall_path = public_path() . "/files/services/wall_services.json";
        $wall_arr = json_decode(file_get_contents($wall_path), true)['Sheet1'];
        foreach ($wall_arr as $service) {
            if (trim($service['unit']) === trim('кв. м') || trim($service['unit']) === trim('кв.м')) {
                Service::create([
                    'service_type_id' => 2,
                    'unit_id' => 1,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }
            if (trim($service['unit']) === trim('шт') || trim($service['unit']) === trim('шт.')) {
                Service::create([
                    'service_type_id' => 2,
                    'unit_id' => 3,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }
            if (trim($service['unit']) === trim('изд.')) {
                Service::create([
                    'service_type_id' => 2,
                    'unit_id' => 4,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('м.')) {
                Service::create([
                    'service_type_id' => 2,
                    'unit_id' => 5,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }
        }

    }

    protected function ceiling_services()
    {
        $ceiling_path = public_path() . "/files/services/ceiling_services.json";
        $ceiling_arr = json_decode(file_get_contents($ceiling_path), true)['Sheet1'];

        foreach ($ceiling_arr as $service) {
            if (trim($service['unit']) === trim('кв.м') || trim($service['unit']) === trim('кв. м')) {
                Service::create([
                    'service_type_id' => 3,
                    'unit_id' => 1,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('шт.')) {
                Service::create([
                    'service_type_id' => 3,
                    'unit_id' => 3,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('м/п')) {
                Service::create([
                    'service_type_id' => 3,
                    'unit_id' => 2,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

        }
    }

    protected function plumbing_services()
    {
        $plumbing_path = public_path() . "/files/services/plumbing_services.json";
        $plumbing_arr = json_decode(file_get_contents($plumbing_path), true)['Sheet1'];

        foreach ($plumbing_arr as $service) {
            if (trim($service['unit']) === trim('шт.')) {
                Service::create([
                    'service_type_id' => 4,
                    'unit_id' => 3,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('точ')) {
                Service::create([
                    'service_type_id' => 4,
                    'unit_id' => 6,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('м/п')) {
                Service::create([
                    'service_type_id' => 4,
                    'unit_id' => 2,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('изд.')) {
                Service::create([
                    'service_type_id' => 4,
                    'unit_id' => 4,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('изд.')) {
                Service::create([
                    'service_type_id' => 4,
                    'unit_id' => 1,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('м.')) {
                Service::create([
                    'service_type_id' => 4,
                    'unit_id' => 5,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

        }
    }

    protected function electricity_services()
    {
        $electricity_path = public_path() . "/files/services/electricity_services.json";
        $electricity_arr = json_decode(file_get_contents($electricity_path), true)['Sheet1'];

        foreach ($electricity_arr as $service) {

            if (trim($service['unit']) === trim('м.')) {
                Service::create([
                    'service_type_id' => 5,
                    'unit_id' => 5,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('шт.')) {
                Service::create([
                    'service_type_id' => 5,
                    'unit_id' => 3,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }

            if (trim($service['unit']) === trim('м.кв')) {
                Service::create([
                    'service_type_id' => 5,
                    'unit_id' => 1,
                    'name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }
        }
    }

    protected function updateCanBeDiscountedColumn()
    {
        $service = Service::where('id', 114)->update([
            'can_be_discounted' => false
        ]);
    }

}
