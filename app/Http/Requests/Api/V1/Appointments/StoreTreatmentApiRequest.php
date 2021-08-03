<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class StoreTreatmentApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'appointment_id'    => 'required',
            'tooth_number'      => 'required',
            'diagnosis_id'      => 'required',
            'is_finished'       => 'required',
        ];
    }
}
