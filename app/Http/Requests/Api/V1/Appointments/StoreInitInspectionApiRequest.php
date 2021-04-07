<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class StoreInitInspectionApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'appointment_id' => ['required',],
            'options' => ['required',],
            'customs' =>['nullable',],
        ];

    }
}
