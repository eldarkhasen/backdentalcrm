<?php

namespace App\Http\Controllers\Api\V1\Settings;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Settings\StoreAndUpdateEmployeeApiRequest;
use App\Services\v1\EmployeesAndPositionsService;
use Illuminate\Http\Request;

class EmployeesController extends ApiBaseController
{
    protected $employeeService;

    /**
     * EmployeesController constructor.
     * @param $employeeService
     */
    public function __construct(EmployeesAndPositionsService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse($this->employeeService->getEmployees());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAndUpdateEmployeeApiRequest $request)
    {
        return $this->successResponse($this->employeeService->storeEmployee($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->successResponse($this->employeeService->getEmployeeById($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAndUpdateEmployeeApiRequest $request, $id)
    {
        return $this->successResponse($this->employeeService->updateEmployee($request,$id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
