<?php


namespace App\Http\Requests\Api\V1\CashFlow;


use App\Http\Requests\ApiBaseRequest;

class CashBoxFilterApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'name' => ['nullable', 'max:255'],
            'balance_positive' => ['nullable', 'boolean'],
            'organization.id' => ['nullable', 'numeric'],
        ];
    }
}
