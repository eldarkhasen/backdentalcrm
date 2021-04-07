<?php


namespace App\Http\Requests\Api\V1\Materials;


use App\Http\Requests\ApiBaseRequest;

class MaterialUsageRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'materialRest.id' => ['required', 'numeric'],
            'employee.id' => ['numeric'],
            'quantity' => ['required', 'numeric'],
            'comments' => ['max:255']
        ];
    }
}
