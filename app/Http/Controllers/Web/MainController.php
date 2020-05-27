<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 22.05.2020
 * Time: 23:39
 */

namespace App\Http\Controllers\Web;


use App\Services\v1\EmployeesAndPositionsService;
use App\Services\v1\OrganizationLogic\OrganizationService;

class MainController
{

    protected $organizationService;
    protected $employeesAndPositionService;

    /**
     * MainController constructor.
     * @param $organizationService
     */
    public function __construct(OrganizationService $organizationService,
                                EmployeesAndPositionsService $employeesAndPositionService)
    {
        $this->organizationService = $organizationService;
        $this->employeesAndPositionService = $employeesAndPositionService;
    }


    public function index()
    {
        dd();
        return view('welcome');
    }
}