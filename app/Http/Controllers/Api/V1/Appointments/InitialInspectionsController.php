<?php

namespace App\Http\Controllers\Api\V1\Appointments;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
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
}
