<?php


namespace App\Http\Requests\Api\V1\CashFlow;


use App\Http\Requests\Api\ApiBaseRequest;

class OperationTypeApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => ['required'],
            'cash_flow_type' => ['required'],
        ];
    }
}