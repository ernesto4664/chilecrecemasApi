<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EtapaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EtapaService::class, function ($app) {
            return new EtapaService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}