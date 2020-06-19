<?php

namespace App\Http\Controllers\Api\V1\CashFlow;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Services\v1\CashFlow\CashFlowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashFlowController extends ApiBaseController
{
    protected $service;
    public function __construct(CashFlowService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CashFlowOperationApiRequest $request
     * @return JsonResponse|object
     */
    public function store(CashFlowOperationApiRequest $request)
    {
        $operation = $this->service->storeOperation($request);
        $this->service->commitOperation($operation);

        return $this->successResponse('OK');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
