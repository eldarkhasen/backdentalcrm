<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class StoreTreatmentTemplateApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'name'=> 'required',
            'code' => 'required|numeric|unique:treatment_templates,code,'. $this->id,
        ];
    }
}
