<?php


namespace App\Services\v1\CashFlow\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\CashFlow\CashFlowOperationApiRequest;
use App\Models\CashFlow\CashFlowOperation;
use App\Services\v1\CashFlow\CashFlowService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashFlowServiceImpl implements CashFlowService
{

    public function storeOperation(CashFlowOperationApiRequest $request)
    {
        DB::beginTransaction();
        try {
            if (!($request->user()->isEmployee() || $request->user()->isOwner())) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'You are not allowed to do so'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            $operation = new CashFlowOperation();

            $operation->fill($request->only([
                'amount',
                'comments'
            ]));

            if (!!$request->get('from_cash_box'))
                $operation->fromCashBox()->attach($request->get('from_cash_box'));

            if (!!$request->get('to_cash_box'))
                $operation->toCashBox()->attach($request->get('to_cash_box'));

            $operation->type()->attach($request->get('type'));
            $operation->appointment()->attach($request->get('appointment'));

            DB::commit();

            return $operation;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'System error',
                    $e->getMessage()
                ],
                'errorCode' => ErrorCode::SYSTEM_ERROR
            ]);
        }
    }

    public function commitOperation(CashFlowOperation $operation)
    {
        DB::beginTransaction();
        try {
            if (!(Auth::user()->isEmployee() || Auth::user()->isOwner())) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'You are not allowed to do so'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

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

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'System error',
                    $e->getMessage()
                ],
                'errorCode' => ErrorCode::SYSTEM_ERROR
            ]);
        }
    }
}