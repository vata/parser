<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Goutte\Client::class, function ($app) {
            $client = new \Goutte\Client();
            $client->setClient(new \GuzzleHttp\Client([
                'timeout' => 20,
                'allow_redirects' => false,
            ]));

            return $client;
        });
    }
}
