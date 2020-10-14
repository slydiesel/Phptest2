<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    

    public $bindings = [
        \App\Contracts\CustomerManagementService::class => \App\Support\Services\CustomerManager::class,
        \App\Contracts\RenderableException::class => \App\Exceptions\APIRequestException::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
