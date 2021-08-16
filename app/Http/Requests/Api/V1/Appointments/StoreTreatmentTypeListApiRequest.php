<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class StoreTreatmentTypeListApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'template_id' => 'required',
            'types' => 'array|required',
            'types.*.name' => 'required',
            'types.*.options' => 'array',
            'types.*.options.*.value' =>'required',
        ];
    }
}
