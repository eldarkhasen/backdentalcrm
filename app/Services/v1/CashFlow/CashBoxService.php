<?php


namespace App\Services\v1\CashFlow;


use App\Http\Requests\Api\V1\CashFlow\CashBoxFilterApiRequest;

interface CashBoxService
{
    public function getCashBoxes(CashBoxFilterApiRequest $request);
}