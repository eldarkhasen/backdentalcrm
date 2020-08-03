<?php


namespace App\Services\v1;


use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAndUpdateAppointmentApiRequest;

interface AppointmentsService
{
    public function getAppointments(FilterAppointmentsApiRequest $request);
    public function getAppointmentsByEmployee(FilterAppointmentsApiRequest $request);
    public function getAppointmentById($id);
    public function storeAppointment(StoreAndUpdateAppointmentApiRequest $request);
    public function updateAppointment(StoreAndUpdateAppointmentApiRequest $request, $id);
    public function deleteAppointment($id);
}