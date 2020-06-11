<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\Api\ApiBaseRequest;

class FilterAppointmentsApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'time_from' => ['date', 'nullable'],
            'time_to' => ['date', 'nullable'],
            'employee_ids' => ['array', 'nullable'],
            'patient_ids' => ['array', 'nullable'],
            'search_key'=> ['nullable', 'max:255']
        ];
    }
}