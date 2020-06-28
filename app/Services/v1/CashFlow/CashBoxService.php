<?php


namespace App\Services\v1\CashFlow;


use App\Http\Requests\Api\V1\CashFlow\CashBoxFilterApiRequest;
use App\Http\Requests\Api\V1\CashFlow\CashBoxRequest;

interface CashBoxService
{
    public function getCashBoxes(CashBoxFilterApiRequest $request = null);

    public function getCashBoxesArray();

    public function getCurrentOrganizationCashBoxes();

    public function getCashBoxById($id);

    public function storeCashBox(CashBoxRequest $request);

    public function updateCashBox(CashBoxRequest $request, $id);

    public function destroyCashBox($id);
}