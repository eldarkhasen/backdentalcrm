<?php


namespace App\Http\Requests\Api\V1\Appointments;


use App\Http\Requests\Api\ApiBaseRequest;

class StoreAndUpdateAppointmentApiRequest extends ApiBaseRequest
{
    public function injectedRules()
    {
        return [
            'title' => ['nullable'],
            'starts_at' => ['required', 'date', 'after:today'],
            'ends_at' => ['required', 'date', 'after:today'],
            'price' => ['required', 'numeric', 'digits_between:0,1000000'],
            'patient.id' => ['required', 'numeric'],
            'patient.surname' => ['required'],
            'patient.name' => ['required'],
            'patient.patronymic' => ['required'],
            'patient.phone' => ['required'],
            'employee.id' => ['required', 'numeric'],
            'employee.color' => ['required'],
            'treatment_course' => ['nullable'],
            'is_first_visit' => ['required', 'boolean'],
            'services'=>['nullable','array']
        ];
    }
}