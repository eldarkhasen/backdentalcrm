<?php


namespace App\Http\Requests\Api\V1\CashFlow;


use App\Http\Requests\ApiBaseRequest;

class CashFlowOperationApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'from_cash_box' => ['nullable'],
            'from_cash_box.id' => ['numeric'],
            'to_cash_box' => ['nullable'],
            'cash_flow_date' => ['nullable'],
            'to_cash_box.id' => ['numeric'],
            'operation_type' => ['required'],
            'appointment' => ['nullable'],
            'amount' => ['numeric'],
            'comments' => ['nullable', 'max:255'],
        ];
    }
}
