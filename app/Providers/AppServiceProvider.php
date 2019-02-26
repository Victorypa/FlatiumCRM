<?php

namespace App\Providers;

use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->app['request']->server->set('HTTPS', true);

        Schema::defaultStringLength(191);

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        Writer::macro('setCreator', function (Writer $writer, string $creator) {
            $writer->getDelegate()->getProperties()->setCreator($creator);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
