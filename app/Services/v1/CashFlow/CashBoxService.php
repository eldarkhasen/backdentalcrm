<?php


namespace App\Services\v1\CashFlow;


use App\Http\Requests\Api\V1\CashFlow\CashBoxFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashBoxRequest;

interface CashBoxService
{
    public function getCashBoxes(CashBoxFilterApiRequest $request);

    public function getCurrentOrganizationCashBoxes();

    public function storeCashBox(CashBoxRequest $request);

    public function updateCashBox(CashBoxRequest $request, $id);

    public function destroyCashBox($id);
}