<?php


namespace App\Http\Requests\Api\V1\Diagnosis;


use App\Http\Requests\ApiBaseRequest;

class DiagnosisStoreApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'name' => 'required',
            'code' => 'required|numeric|unique:diagnoses,code,'. $this->id,
//            'organization_id' => 'required',
        ];
    }
}
