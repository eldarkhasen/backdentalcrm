<?php


namespace App\Http\Requests\Api\V1\Materials;


use App\Http\Requests\Api\ApiBaseRequest;

class MaterialUsageRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'materialRest.id' => ['required', 'numeric'],
            'employee.id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'comments' => ['required', 'max:255']
        ];
    }
}