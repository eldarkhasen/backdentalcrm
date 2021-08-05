<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\ApiBaseRequest;

class UpdateTreatmentDataListApiRequest extends ApiBaseRequest
{

    public function injectedRules()
    {
        return [
            'id' => 'required',
            'template_id' => 'required',
            'types' => 'array|required',
            'types.*.id' => 'required',
//            'types.*.value' => 'required_without:types.*.options',
            'types.*.options' => 'array',
            'types.*.options.*.id' =>  'required_with:types.*.options.*.is_checked',
            'types.*.options.*.is_checked' =>  'required_with:types.*.options.*.id',
        ];
    }
}
