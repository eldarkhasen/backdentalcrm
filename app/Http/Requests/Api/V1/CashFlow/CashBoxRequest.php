<?php


namespace App\Http\Requests\Api\V1\CashFlow;


use App\Http\Requests\Api\ApiBaseRequest;

class CashBoxRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'name' => ['required', 'max:255'],
            'balance' => ['required', 'numeric']
        ];
    }
}