<?php


namespace App\Http\Requests\Api\V1\Materials;


use App\Http\Requests\Api\ApiBaseRequest;

class MaterialRestRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'material.id' => ['required', 'numeric'],
            'organization.id' => ['required', 'numeric'],
            'count' => ['required', 'numeric']
        ];
    }
}