<?php

namespace App\Http\Controllers\Api\V1\CashFlow;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationFilterApiRequest;
use App\Http\Resources\CashFlowOperationResource;
use App\Services\v1\CashFlow\CashFlowService;
use Illuminate\Http\JsonResponse;

class CashFlowController extends ApiBaseController
{
    protected $service;
    public function __construct(CashFlowService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->successResponse(
            CashFlowOperationResource::collection(
                $this->service->getOperations()
            )
        );
    }

    public function indexFiltered(CashFlowOperationFilterApiRequest $request)
    {
        return $this->successResponse(
            CashFlowOperationResource::collection(
                $this->service->getOperations($request)
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CashFlowOperationApiRequest $request
     * @return JsonResponse|object
     */
    public function store(CashFlowOperationApiRequest $request)
    {
        return $this->successResponse(
            new CashFlowOperationResource(
                $this->service->storeOperation($request)
            )
        );
    }

    public function update(CashFlowOperationApiRequest $request, $id)
    {
        return $this->successResponse(
            new CashFlowOperationResource(
                $this->service->updateOperation($request, $id)
            )
        );
    }

    public function destroy($id)
    {
        $this->service->destroyOperation($id);
        return $this->successResponse('OK');
    }
}
