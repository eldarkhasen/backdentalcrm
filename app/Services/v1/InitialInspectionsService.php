<?php


namespace App\Services\v1;


use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\UpdateAppointmentApiRequest;
use Illuminate\Http\Request;

interface InitialInspectionsService
{
    public function getInitialInspectionTypes();
    public function store(Request $request);
    public function delete($id);
}
