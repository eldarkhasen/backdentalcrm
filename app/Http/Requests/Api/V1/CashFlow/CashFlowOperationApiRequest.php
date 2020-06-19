<?php


namespace App\Http\Requests\Api\V1\CashFlow;


use App\Http\Requests\Api\ApiBaseRequest;

class CashFlowOperationApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'from   _cash_box' => ['nullable'],
            'to_cash_box' => ['nullable'],
            'type' => ['required'],
            'appointment' => ['nullable'],
            'amount' => ['numeric'],
            'comments' => ['max:255'],
        ];
    }
}