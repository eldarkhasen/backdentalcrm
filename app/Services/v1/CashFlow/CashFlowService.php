<?php


namespace App\Services\v1\CashFlow;


use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationFilterApiRequest;
use App\Models\CashFlow\CashFlowOperation;

interface CashFlowService
{
    public function getOperations(CashFlowOperationFilterApiRequest $request = null);

    public function storeOperation(CashFlowOperationApiRequest $request);

    public function updateOperation(CashFlowOperationApiRequest $request, $id);

    public function commitOperation(CashFlowOperation $operation);

    public function revertOperation(CashFlowOperation $operation);

    public function destroyOperation($id);
}