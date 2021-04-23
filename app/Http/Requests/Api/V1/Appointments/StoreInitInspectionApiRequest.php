<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class StoreInitInspectionApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'appointment_id' => ['required',],
            'inspection_type_id' => ['required',],
            'inspection_option_id' => ['required_without:is_custom',],
            'is_custom' =>['nullable',],
//            'value' => ['required_with:is_custom',],
            'is_checked' => 'required',
//            'appointment_id' => ['required',],   // for bigStore
//            'options' => ['required', 'array'],
//            'options.*'  => ['required', 'array'],
//            'customs' =>['nullable', 'array'],
        ];

    }
}
