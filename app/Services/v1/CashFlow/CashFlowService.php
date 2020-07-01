<?php


namespace App\Services\v1\CashFlow;


use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\OperationTypeApiRequest;
use App\Models\CashFlow\CashFlowOperation;
use Illuminate\Http\Request;

interface CashFlowService
{
    public function getOperations( $perPage);

    public function getCurrentWeekOperations($perPage);

    public function storeOperation(CashFlowOperationApiRequest $request);

    public function updateOperation(CashFlowOperationApiRequest $request, $id);

    public function commitOperation(CashFlowOperation $operation);

    public function revertOperation(CashFlowOperation $operation);

    public function destroyOperation($id);

    public function getOperationTypes($perPage);

    public function searchOperationTypes($perPage,$keyWord);

    public function storeOperationType(OperationTypeApiRequest $request);

    public function updateOperationType(OperationTypeApiRequest $request,$id);

    public function deleteOperationType($id);

    public function getCashFlowTypes();

    public function getOperationTypesByType();
}