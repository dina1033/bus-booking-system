<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Service\{BaseService};
use App\Service\{ServiceInterface};


class BusinessServiceLayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ServiceInterface::class, BaseService::class);


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
