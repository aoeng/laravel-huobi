<?php

namespace Aoeng\Laravel\Huobi;


use Illuminate\Support\ServiceProvider;

class HuobiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/huobi.php' => config_path('huobi.php'),
        ], 'huobi');

    }

    public function register()
    {
        $this->app->singleton('huobi', function ($app) {
            return new HuobiSpot();
        });

        $this->app->singleton('huobiFuture', function ($app) {
            return new HuobiFuture();
        });


    }

}
