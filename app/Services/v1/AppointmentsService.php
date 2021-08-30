<?php


namespace App\Services\v1;


use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAppointmentApiRequest;
use App\Http\Requests\Api\V1\Appointments\UpdateAppointmentApiRequest;
use Illuminate\Http\Request;

interface AppointmentsService
{
    public function getAppointments(FilterAppointmentsApiRequest $request, $currentUser);
    public function getAppointmentsByEmployee(FilterAppointmentsApiRequest $request);
    public function getAppointmentById($id);
    public function storeAppointment(StoreAppointmentApiRequest $request);
    public function updateAppointment(UpdateAppointmentApiRequest $request, $id);
    public function deleteAppointment($id);
    public function getPatientLastAppointments($patient_id, $currentUser);
    public function updateAppointmentTime($id, $starts_at,$ends_at);
    public function getAppointmentTreatments($id);
    public function getAppointmentInitialInspections($id);
}
