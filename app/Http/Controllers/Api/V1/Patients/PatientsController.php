<?php

namespace App\Http\Controllers\Api\V1\Patients;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Patients\StoreAndUpdatePatientApiRequest;
use App\Services\v1\PatientsService;
use Illuminate\Http\Request;

class PatientsController extends ApiBaseController
{
    protected $patientsService;

    /**
     * PatientsController constructor.
     * @param $patientsService
     */
    public function __construct(PatientsService $patientsService)
    {
        $this->patientsService = $patientsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('perPage',10);
        if($request->has('search') && $request->has('array')){
            return $this->successResponse($this->patientsService->searchPatientsArray($request->get('search')));
        }else if($request->has('search') && !$request->has('array')){
            return $this->successResponse($this->patientsService->searchPaginatedPatients($request->get('search'),$perPage));
        }else if($request->has('array')){
            return $this->successResponse($this->patientsService->getAllPatientsArray());
        }else{
            return $this->successResponse($this->patientsService->getAllPaginatedPatients($perPage));
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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAndUpdatePatientApiRequest $request)
    {
        return $this->successResponse($this->patientsService->storePatient($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->successResponse($this->patientsService->getPatientById($id));
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
    public function update(StoreAndUpdatePatientApiRequest $request, $id)
    {
        return $this->successResponse($this->patientsService->updatePatient($request,$id));
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