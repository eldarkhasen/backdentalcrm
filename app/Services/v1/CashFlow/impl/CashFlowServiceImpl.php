<?php


namespace App\Services\v1\CashFlow\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\OperationTypeApiRequest;
use App\Models\CashFlow\CashFlowOperation;
use App\Models\CashFlow\CashFlowOperationType;
use App\Models\CashFlow\CashFlowType;
use App\Services\v1\BaseServiceImpl;
use App\Services\v1\CashFlow\CashFlowService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashFlowServiceImpl
    extends BaseServiceImpl
    implements CashFlowService
{

    public function getOperations($perPage)
    {
        $org_id = $this->getUserOrganizationId(auth()->user());

        // TODO: realize filters
        return CashFlowOperation::with(['fromCashBox', 'toCashBox', 'type', 'appointment','employee','type.cashFlowType'])
            ->where('committed', true)
            ->whereHas('employee', function ($q) use ($org_id){
                $q->where('organization_id', $org_id);
            })
            ->paginate($perPage);
    }

    public function storeOperation(CashFlowOperationApiRequest $request)
    {
        $operation = null;
        DB::beginTransaction();
        try {
            $this->validateUserAccess(auth()->user());

            $operation = new CashFlowOperation();

            $operation = $this->fillOperation($operation, $request);

            $operation->save();

            $this->commitOperation($operation);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        return $operation;
    }

    public function updateOperation(CashFlowOperationApiRequest $request, $id)
    {
        $operation = null;
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $operation = CashFlowOperation::findOrFail($id);

            $this->revertOperation($operation);

            $operation = $this->fillOperation($operation, $request);

            $operation->save();

            $this->commitOperation($operation);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        return $operation;
    }

    private function fillOperation(CashFlowOperation $operation, CashFlowOperationApiRequest $request)
    {
        $operation->fill($request->only([
            'amount',
            'comments'
        ]));

        if (!!$request->get('from_cash_box'))
            $operation->from_cash_box_id = $request->get('from_cash_box');

        if (!!$request->get('to_cash_box'))
            $operation->to_cash_box_id = $request->get('to_cash_box');

        if (!!$request->get('appointment')) {
            $operation->appointment_id = $request->get('appointment');
        }

        $operation->type_id = $request->get('operation_type');

        $operation->cash_flow_date = $request->get('cash_flow_date');

        $operation->user_created_id = Auth::user()->employee->id;

        return $operation;
    }

    public function commitOperation(CashFlowOperation $operation)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess(Auth::user());
            if ($operation->committed) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'Operation had already been committed.'
                    ],
                    'errorCode' => ErrorCode::ALREADY_REQUESTED
                ]);
            }

            if (!!$operation->fromCashBox) {
                $operation->fromCashBox->update([
                    'balance' => intval(
                        $operation->fromCashBox->balance - $operation->amount
                    )
                ]);
            }

            if (!!$operation->toCashBox) {
                $operation->toCashBox->update([
                    'balance' => intval(
                        $operation->toCashBox->balance + $operation->amount
                    )
                ]);
            }
            $operation->update([
                'user_created_id'=> auth()->user()->employee->id
            ]);
            $operation->update([
                'committed' => true
            ]);

            DB::commit();

        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        return;
    }

    public function revertOperation(CashFlowOperation $operation)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess(Auth::user());

            if (!$operation->committed) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'Operation had not been committed yet.'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            if (!!$operation->fromCashBox) {
                $operation->fromCashBox->update([
                    'balance' => intval(
                        $operation->fromCashBox->balance + $operation->amount
                    )
                ]);
            }

            if (!!$operation->toCashBox) {
                $operation->toCashBox->update([
                    'balance' => intval(
                        $operation->toCashBox->balance - $operation->amount
                    )
                ]);
            }

            $operation->update([
                'committed' => false
            ]);

            DB::commit();
        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }

        return;
    }

    public function destroyOperation($id)
    {
        $operation = CashFlowOperation::findOrFail($id);

        $this->revertOperation($operation);

        return $operation->delete();
    }

    public function getOperationTypes($perPage = 10)
    {
        // TODO: fix bag with getting operation types. Operation types, related to organization goes in each paginated page
        if ($this->userHasAccess(Auth::user())) {
            Auth::user()->load('employee.organization.cashFlowOperationTypes');
            $org_id = $this->getUserOrganizationId(Auth::user());

            return CashFlowOperationType::where('organization_id', null)
                ->orWhere('organization_id', $org_id)
                ->with('cashFlowType')
                ->orderBy('id')
                ->paginate($perPage);
        }
        return null;
    }

    public function searchOperationTypes($perPage, $keyWord)
    {
        if ($this->userHasAccess(Auth::user())) {
            Auth::user()->load('employee.organization.cashFlowOperationTypes');
            $org_id = $this->getUserOrganizationId(Auth::user());
            return CashFlowOperationType::where(function ($query) use ($keyWord, $org_id) {
                $query->where('name', 'LIKE', '%' . $keyWord . '%');
                $query->where('organization_id', $org_id);
            })->orWhere(function ($query) use ($keyWord) {
                $query->where('name', 'LIKE', '%' . $keyWord . '%');
                $query->where('organization_id', null);
            })
                ->with('cashFlowType')
                ->paginate($perPage);
        }
        return null;
    }

    public function getCashFlowTypes()
    {
        if ($this->userHasAccess(Auth::user())) {
            return CashFlowType::all();
        }

        return null;
    }

    public function storeOperationType(OperationTypeApiRequest $request)
    {
        $org_id = $this->getUserOrganizationId(auth()->user());

        return CashFlowOperationType::create([
            'name' => $request->name,
            'cash_flow_type_id' => $request->cash_flow_type,
            'organization_id' => $org_id
        ]);
    }

    public function updateOperationType(OperationTypeApiRequest $request, $id)
    {
        $operationType = CashFlowOperationType::findOrFail($id);
        return $operationType->update([
            'name' => $request->name,
            'cash_flow_type_id' => $request->cash_flow_type
        ]);
    }

    public function deleteOperationType($id)
    {
        $operationType = CashFlowOperationType::findOrFail($id);
        if (count($operationType->cashFlowOperation) > 0) {
            throw new ApiServiceException(400, false,
                ['message' => 'Нельзя удалить данную статью платежей',
                    'errorCode' => ErrorCode::NOT_ALLOWED]);
        }
        return CashFlowOperationType::destroy($id);
    }

    public function getOperationTypesByType()
    {
        if ($this->userHasAccess(Auth::user())) {
            Auth::user()->load('employee.organization.cashFlowOperationTypes');
            $org_id = $this->getUserOrganizationId(Auth::user());

            return CashFlowOperationType::where('organization_id', null)
                ->orWhere('organization_id', $org_id)
                ->with('cashFlowType')
                ->orderBy('id')
                ->get();
        }
        return null;
    }

    public function getCurrentWeekOperations($perPage)
    {
        $org_id = $this->getUserOrganizationId(auth()->user());

        // TODO: realize filters
        return CashFlowOperation::with(['fromCashBox', 'toCashBox', 'type', 'appointment','employee','type.cashFlowType'])
            ->where('committed', true)
            ->whereHas('employee', function ($q) use ($org_id){
                $q->where('organization_id', $org_id);
                $q->whereBetween('cash_flow_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            })->orderBy('id','desc')
            ->paginate($perPage);

    }
}