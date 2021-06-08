<?php

namespace App\Providers;

use App\Services\v1\AppointmentsService;
use App\Services\v1\CashFlow\CashBoxService;
use App\Services\v1\CashFlow\CashFlowService;
use App\Services\v1\CashFlow\impl\CashBoxServiceImpl;
use App\Services\v1\CashFlow\impl\CashFlowServiceImpl;
use App\Services\v1\impl\AppointmentsServiceImpl;
use App\Services\v1\impl\AuthServiceImpl;
use App\Services\v1\impl\EmployeesAndPositionsServiceImpl;
use App\Services\v1\impl\InitialInspectionServiceImpl;
use App\Services\v1\impl\MaterialsServiceImpl;
use App\Services\v1\impl\PatientsServiceImpl;
use App\Services\v1\impl\PermissionsServiceImpl;
use App\Services\v1\impl\ProfileServiceImpl;
use App\Services\v1\impl\ServicesServiceImpl;
use App\Services\v1\impl\TreatmentTemplatesServiceImpl;
use App\Services\v1\InitialInspectionsService;
use App\Services\v1\MaterialsService;
use App\Services\v1\OrganizationLogic\impl\OrganizationServiceImpl;
use App\Services\v1\SubscriptionLogic\impl\SubscriptionServiceImpl;
use App\Services\v1\SubscriptionLogic\impl\SubscriptionTypeServiceImpl;
use App\Services\v1\Support\impl\SupportServiceImpl;
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
        $this->app->bind('App\Services\v1\PatientsService', function ($app) {
            return (new PatientsServiceImpl());
        });
        $this->app->bind('App\Services\v1\SubscriptionLogic\SubscriptionService', function ($app) {
            return (new SubscriptionServiceImpl());
        });
        $this->app->bind('App\Services\v1\SubscriptionLogic\SubscriptionTypeService', function ($app) {
            return (new SubscriptionTypeServiceImpl());
        });
        $this->app->bind('App\Services\v1\OrganizationLogic\OrganizationService', function ($app) {
            return (new OrganizationServiceImpl());
        });
        $this->app->bind('App\Services\v1\TreatmentTemplatesService', function ($app) {
            return (new TreatmentTemplatesServiceImpl());
        });
        $this->app->bind('App\Services\v1\ProfileService', function ($app) {
            return (new ProfileServiceImpl());
        });
        $this->app->bind('App\Services\v1\Support\SupportService', function ($app) {
            return (new SupportServiceImpl());
        });
        $this->app->bind(AppointmentsService::class, function ($app) {
            return (new AppointmentsServiceImpl());
        });
        $this->app->bind(CashFlowService::class, function ($app) {
            return (new CashFlowServiceImpl());
        });
        $this->app->bind(CashBoxService::class, function ($app) {
            return (new CashBoxServiceImpl());
        });
        $this->app->bind(MaterialsService::class, function ($app) {
            return (new MaterialsServiceImpl());
        });
        $this->app->bind(InitialInspectionsService::class, function ($app) {
            return (new InitialInspectionServiceImpl());
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
