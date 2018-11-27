<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class DataFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:fetch';

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
        Artisan::call('db:seed');
        Artisan::call('amo:data');
        Artisan::call('service:data');
        Artisan::call('material:data');
    }
}
