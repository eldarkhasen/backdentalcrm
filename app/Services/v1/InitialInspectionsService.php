<?php


namespace App\Services\v1;


use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAndUpdateAppointmentApiRequest;
use Illuminate\Http\Request;

interface InitialInspectionsService
{
    public function getInitialInspectionTypes();

}
