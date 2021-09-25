<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class TreatmentDataStoreListApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'appointment_id' => 'required',
            'tooth_number' => 'required',
            'diagnosis_id' => 'required',
            'is_finished' => 'required',
            'teeth' => 'array|required',
//            'treatment_id' => 'required',
            'template_id' => 'required',
            'data' => 'array|required',
            'data.*.type_id' => 'required',
            'data.*.option_id' => 'required_without:data.*.value',
            'data.*.value' => 'required_without:data.*.option_id',
        ];
    }
}
