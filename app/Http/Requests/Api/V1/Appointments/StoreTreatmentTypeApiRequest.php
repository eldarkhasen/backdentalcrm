<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class StoreTreatmentTypeApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'name'=> 'required',
            'template_id'=> 'required',
        ];
    }
}
