<?php


namespace App\Services\v1\CashFlow\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationFilterApiRequest;
use App\Models\CashFlow\CashFlowOperation;
use App\Services\v1\BaseServiceImpl;
use App\Services\v1\CashFlow\CashFlowService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashFlowServiceImpl
    extends BaseServiceImpl
    implements CashFlowService {

    public function getOperations(CashFlowOperationFilterApiRequest $request)
    {
        // TODO: realize filters
        return CashFlowOperation::with(['fromCashBox', 'toCashBox', 'type', 'appointment'])
            ->where('committed', true)
            ->get();
    }

    public function storeOperation(CashFlowOperationApiRequest $request)
    {
        $operation = null;
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

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
            $operation->from_cash_box_id = $request->get('from_cash_box')['id'];

        if (!!$request->get('to_cash_box'))
            $operation->to_cash_box_id = $request->get('to_cash_box')['id'];

        if (!!$request->get('appointment')) {
            $operation->appointment_id = $request->get('appointment')['id'];
        }

        $operation->type_id = $request->get('type')['id'];

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

    public function destroyOperation($id) {
        $operation = CashFlowOperation::findOrFail($id);

        $this->revertOperation($operation);

        return $operation->delete();
    }
}