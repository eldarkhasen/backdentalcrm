<?php

namespace App\Http\Controllers\Api\V1\Appointments;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Appointments\StoreInitInspectionApiRequest;
use App\Http\Resources\InitialInspectionTypeResource;
use App\Services\v1\InitialInspectionsService;
use Illuminate\Http\Request;

class InitialInspectionsController extends ApiBaseController
{
    protected $initialInspectionService;

    /**
     * InitialInspectionsController constructor.
     * @param $initialInspectionService
     */
    public function __construct(InitialInspectionsService $initialInspectionService)
    {
        $this->initialInspectionService = $initialInspectionService;
    }

    public function getInitialInspectionTypes()
    {
        return $this->successResponse(
            $this->initialInspectionService->getInitialInspectionTypes()
        );
    }

    public function store(StoreInitInspectionApiRequest $request){
        return $this->successResponse(
            $this->initialInspectionService->store($request)
        );
    }

    public function delete($id){
        return $this->successResponse(
            $this->initialInspectionService->delete($id)
        );
    }
}
