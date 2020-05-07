<?php

namespace App\Providers;

use App\Services\v1\impl\AuthServiceImpl;
use App\Services\v1\impl\EmployeesAndPositionsServiceImpl;
use App\Services\v1\impl\PermissionsServiceImpl;
use App\Services\v1\impl\ServicesServiceImpl;
use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('App\Services\v1\AuthService', function ($app) {
            return (new AuthServiceImpl());
        });

        $this->app->bind('App\Services\v1\PermissionsService', function ($app) {
            return (new PermissionsServiceImpl());
        });
        $this->app->bind('App\Services\v1\ServicesService', function ($app) {
            return (new ServicesServiceImpl());
        });
        $this->app->bind('App\Services\v1\EmployeesAndPositionsService', function ($app) {
            return (new EmployeesAndPositionsServiceImpl());
        });




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
