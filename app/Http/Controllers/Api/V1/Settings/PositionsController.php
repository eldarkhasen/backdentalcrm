<?php

namespace App\Http\Controllers\Api\V1\Settings;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Settings\StoreAndUpdatePositionApiRequest;
use App\Services\v1\EmployeesAndPositionsService;
use Illuminate\Http\Request;

class PositionsController extends ApiBaseController
{
    protected $positionsService;

    /**
     * PositionsController constructor.
     * @param $positionsService
     */
    public function __construct(EmployeesAndPositionsService $positionsService)
    {
        $this->positionsService = $positionsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')){
            return $this->successResponse($this->positionsService->searchPosition($request->get('search')));
        }
        return $this->successResponse($this->positionsService->getPositions());
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
    public function store(StoreAndUpdatePositionApiRequest $request)
    {
        return $this->successResponse($this->positionsService->storePosition($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->successResponse($this->positionsService->getPositionById($id));
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
    public function update(StoreAndUpdatePositionApiRequest $request, $id)
    {
        return $this->successResponse($this->positionsService->updatePosition($id,$request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->successResponse($this->positionsService->deletePosition($id));
    }

}
