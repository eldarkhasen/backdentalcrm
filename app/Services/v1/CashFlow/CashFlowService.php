<?php


namespace App\Services\v1\CashFlow;


use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Models\CashFlow\CashFlowOperation;

interface CashFlowService
{
    public function storeOperation(CashFlowOperationApiRequest $request);

    public function commitOperation(CashFlowOperation $operation);
}