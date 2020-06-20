<?php


namespace App\Services\v1\CashFlow\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\CashFlow\CashBoxFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashBoxRequest;
use App\Models\CashFlow\CashBox;
use App\Services\v1\BaseServiceImpl;
use App\Services\v1\CashFlow\CashBoxService;
use Illuminate\Support\Facades\DB;

class CashBoxServiceImpl
    extends BaseServiceImpl
    implements CashBoxService
{

    public function getCashBoxes(CashBoxFilterApiRequest $request)
    {
        // TODO: Implement getCashBoxes() method.
    }

    public function storeCashBox(CashBoxRequest $request)
    {
        return $this->storeOrUpdateCashBox($request);
    }

    public function updateCashBox(CashBoxRequest $request, $id)
    {
        return $this->storeOrUpdateCashBox($request, $id);
    }

    private function storeOrUpdateCashBox(CashBoxRequest $request, $id = null)
    {
        $cashbox = null;
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            if (!!$id) {
                $cashbox = CashBox::findOrFail($id)
                    ->update([
                        $request->only([
                            'name',
                            'balance'
                        ])
                    ]);
            } else {
                $cashbox = CashBox::create($request->only([
                    'name',
                    'balance'
                ]));
            }

            DB::commit();
        } catch (\Exception $e) {
           $this->onError($e);
        }

        return $cashbox;
    }

    public function destroyCashBox($id)
    {
        return CashBox::destroy($id);
    }
}