<?php

namespace App\Http\Controllers\Api\V1\CashFlow;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\CashFlow\CashBoxFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashBoxRequest;
use App\Http\Resources\CashBoxResource;
use App\Services\v1\CashFlow\CashBoxService;

class CashBoxController extends ApiBaseController
{

    protected $service;

    public function __construct(CashBoxService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->successResponse(
            CashBoxResource::collection(
                $this->service->getCurrentOrganizationCashBoxes()
            )
        );
    }

    public function indexFiltered(CashBoxFilterApiRequest $request)
    {
        return $this->successResponse(
            CashBoxResource::collection(
                $this->service->getCashBoxes($request)
            )
        );
    }

    public function getOrganizationCashBoxes()
    {
        return $this->successResponse(
            CashBoxResource::collection(
                $this->service->getCurrentOrganizationCashBoxes()
            )
        );
    }

    public function store(CashBoxRequest $request)
    {
        return $this->successResponse(
            new CashBoxResource(
                $this->service->storeCashBox($request)
            )
        );
    }

    public function update(CashBoxRequest $request, $id)
    {
        return $this->successResponse(
            new CashBoxResource(
                $this->service->updateCashBox($request, $id)
            )
        );
    }

    public function destroy($id)
    {
        $this->service->destroyCashBox($id);
        return $this->successResponse('OK');
    }

    public function show($id){
        return $this->successResponse($this->service->getCashBoxById($id));
    }
}