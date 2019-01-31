<?php

namespace App\Console\Commands;

use App\Models\Services\Service;
use Illuminate\Console\Command;

class ServicePriceMarkup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:markup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Markup service prices';

    public function handle()
    {
        $services = Service::get();

        foreach ($services as $service) {
            $service->update([
                'price' => (int) ($service->price * 1.05)
            ]);
        }
    }
}
