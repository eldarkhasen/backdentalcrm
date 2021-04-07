<?php


namespace App\Http\Requests\Api\V1\Materials;


use App\Http\Requests\ApiBaseRequest;

class MaterialRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'measure_unit' => ['required'],
            'producer' => ['max:255'],
            'description' => ['nullable']
        ];
    }
}
