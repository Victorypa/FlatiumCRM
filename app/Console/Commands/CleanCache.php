<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class CleanCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean config cache and cache';

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
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
    }
}
