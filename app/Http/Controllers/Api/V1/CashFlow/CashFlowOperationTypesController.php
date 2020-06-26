<?php

namespace App\Http\Controllers\Api\V1\CashFlow;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\OperationTypeApiRequest;
use App\Models\CashFlow\CashFlowOperationType;
use App\Services\v1\CashFlow\CashFlowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashFlowOperationTypesController extends ApiBaseController
{
    protected $service;
    public function __construct(CashFlowService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('perPage',10);
        if($request->has('search')){
            return $this->successResponse($this->service->searchOperationTypes($perPage,$request->get('search')));
        }else{
            return $this->successResponse($this->service->getOperationTypes($perPage));
        }

    }

    public function indexFiltered(CashFlowOperationFilterApiRequest $request)
    {
    }

    public function store(OperationTypeApiRequest $request){
        return $this->successResponse($this->service->storeOperationType($request));
    }

    public function update($id,OperationTypeApiRequest $request)
    {
        return $this->successResponse($this->service->updateOperationType($request,$id));
    }

    public function destroy($id)
    {
        return $this->successResponse($this->service->deleteOperationType($id));
    }

    public function getCashFlowTypes(){
        return $this->successResponse($this->service->getCashFlowTypes());
    }

    public function checkOperationType(){

    }

}
