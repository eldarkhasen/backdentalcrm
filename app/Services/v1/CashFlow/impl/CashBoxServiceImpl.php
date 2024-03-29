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

    public function getCashBoxes(CashBoxFilterApiRequest $request = null)
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
        $currentUser = auth()->user();
        DB::beginTransaction();
        try {
            $this->validateUserAccess($currentUser);

            //Revert all cashboxes if this box is main
            if($request->get('is_main')){
                CashBox::query()->update(['is_main'=>false]);
            }
            if (!!$id) {
                $cashbox = CashBox::findOrFail($id);
                $cashbox->fill([
                    $request->only([
                        'name',
                        'balance',
                        'is_main'
                    ])
                ]);
                $cashbox->organization_id = $currentUser->employee->organization->id;

                $cashbox->save();
            } else {
                $cashbox = new CashBox();

                $cashbox->fill($request->only([
                    'name',
                    'balance',
                    'is_main'
                ]));

                $cashbox->organization_id = $currentUser->employee->organization->id;

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

            $org_id =  Auth::user()->employee->organization->id;
            return CashBox::where('organization_id',$org_id)->with('organization')->get();
        }

        return null;
    }

    public function getCashBoxById($id)
    {
        if ($this->userHasAccess(Auth::user())) {
            Auth::user()->load('employee.organization.cashBoxes');

            return Auth::user()->employee->organization->cashBoxes()->findOrFail($id);
        }

        return null;
    }

    public function getCashBoxesArray()
    {
        if ($this->userHasAccess(Auth::user())) {
            Auth::user()->load('employee.organization.cashBoxes');

            return Auth::user()->employee->organization->cashBoxes;
        }

        return null;
    }

    public function checkCashBox($id, $amount)
    {
        $cashBox = CashBox::findOrFail($id);
        return $cashBox->balance >= $amount;
    }
}
