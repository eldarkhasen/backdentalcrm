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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage',10);
        if($request->has('search') && !$request->has('position')){
            return $this->successResponse($this->employeeService->searchEmployee(auth()->user(),$request->get('search'),$perPage));

        }else if($request->has('position') && !$request->has('search')){
            return $this->successResponse($this->employeeService->getEmployeeByPosition(auth()->user(),$request->get('position'),$perPage));

        }else if($request->has('position') && $request->has('search')){
            return $this->successResponse($this->employeeService->searchEmployeeByPosition(auth()->user(),$request->get('search'),$request->get('position'),$perPage));
        }else if($request->has('array')){
            return $this->successResponse($this->employeeService->getEmployeesArray(auth()->user()));
        } else{
            return $this->successResponse($this->employeeService->getEmployees(auth()->user(),$perPage));
        }

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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function store(StoreAndUpdateEmployeeApiRequest $request)
    {
        return $this->successResponse($this->employeeService->storeEmployee(auth()->user(),$request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function update(StoreAndUpdateEmployeeApiRequest $request, $id)
    {
        return $this->successResponse($this->employeeService->updateEmployee($request,$id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy($id)
    {
        return $this->successResponse($this->employeeService->deleteEmployee($id));
    }
}
