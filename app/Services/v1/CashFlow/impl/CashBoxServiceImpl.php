<?php


namespace App\Services\v1\CashFlow\impl;

use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\CashFlow\CashBoxFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashBoxRequest;
use App\Models\CashFlow\CashBox;
use App\Services\v1\BaseServiceImpl;
use App\Services\v1\CashFlow\CashBoxService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashBoxServiceImpl
    extends BaseServiceImpl
    implements CashBoxService
{

    public function getCashBoxes(CashBoxFilterApiRequest $request)
    {
        return CashBox::with(['organization'])->get();
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
                $cashbox = CashBox::findOrFail($id);
                $cashbox->fill([
                    $request->only([
                        'name',
                        'balance',
                    ])
                ]);
                $cashbox->organization_id = $request->get('organization')['id'];

                $cashbox->save();
            } else {
                $cashbox = new CashBox();

                $cashbox->fill($request->only([
                    'name',
                    'balance'
                ]));

                $cashbox->organization_id = $request->get('organization')['id'];

                $cashbox->save();
            }

            DB::commit();
        } catch (\Exception $e) {
           $this->onError($e, 'System Error', ErrorCode::SYSTEM_ERROR);
        }

        return $cashbox;
    }

    public function destroyCashBox($id)
    {
        return CashBox::destroy($id);
    }

    public function getCurrentOrganizationCashBoxes()
    {
        if ($this->userHasAccess(Auth::user())) {
            Auth::user()->load('employee.organization.cashBoxes');

            return Auth::user()->employee->organization->cashBoxes;
        }

        return null;
    }
}