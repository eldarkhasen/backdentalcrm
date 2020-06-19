<?php


namespace App\Http\Requests\Api\V1\CashFlow;


use App\Http\Controllers\ApiBaseController;
use App\Http\Resources\CashBoxResource;
use App\Services\v1\CashFlow\CashBoxService;

class CashBoxController extends ApiBaseController
{

    protected $service;

    public function __construct(CashBoxService $service)
    {
        $this->service = $service;
    }

    public function index(CashBoxFilterApiRequest $request)
    {
        return $this->successResponse(
            CashBoxResource::collection(
                $this->service->getCashBoxes($request)
            )
        );
    }
}