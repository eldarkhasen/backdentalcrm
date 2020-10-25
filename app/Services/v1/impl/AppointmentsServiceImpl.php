<?php


namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAndUpdateAppointmentApiRequest;
use App\Models\Business\Appointment;
use App\Models\Business\TreatmentCourse;
use App\Services\v1\AppointmentsService;
use App\Services\v1\BaseServiceImpl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentsServiceImpl
    extends BaseServiceImpl
    implements AppointmentsService
{

    public function getAppointments(FilterAppointmentsApiRequest $request, $currentUser)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $time_from = $request->get('time_from', null);
        $time_to = $request->get('time_to', null);
        $search_key = $request->get('search_key', null);

        $query = Appointment::with(['employee', 'patient','treatmentCourse', 'employee.organization','services']);

        if (!!$time_from)
            $query = $query->whereDate('starts_at', '>=', Carbon::parse($time_from));

        if (!!$time_to)
            $query = $query->whereDate('ends_at', '<=', Carbon::parse($time_to));

        if (!!$search_key and $search_key != '')
            $query = $query->where('title', 'like', '%' . $search_key . '%');

        $query = $query->whereHas('employee', function($query) use ($currentUser){
            $query->where('organization_id',$currentUser->employee->organization->id);
        });
        return $query->get();
    }

    public function getAppointmentById($id)
    {
        return Appointment::with(['employee', 'patient', 'treatmentCourse', 'services'])->findOrfail($id);
    }

    public function storeAppointment(StoreAndUpdateAppointmentApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $appointment = new Appointment();
            $patient = $request->get('patient');
            $employee = $request->get('employee');
            $appointment->fill([
                'starts_at' => Carbon::parse($request->get('starts_at')),
                'ends_at' => Carbon::parse($request->get('ends_at')),
                'employee_id' => $employee['id'],
                'patient_id' => $patient['id'],
                'color' => $employee['color'],
                'price' => data_get($request, 'price'),
                'is_first_visit' => data_get($request, 'is_first_visit')
            ]);

            $patient = $request->get('patient');
            $appointment->title = $patient['surname'] . " " .
                $patient['name'] . " " . $patient['patronymic'] . ", " . $patient['phone'];

            $course_id = !!$request->treatment_course
                ? $request->treatment_course['id']
                : TreatmentCourse::create(['name' => $appointment->title, 'is_finished' => false])->id;

            $appointment->treatment_course_id = $course_id;
            $appointment->save();
            $services = $request->services;

            if (isset($services)) {
                foreach ($services as $serv) {
                    $appointment->services()->attach($serv['service']['id'], ['amount'=>$serv['quantity']]);
                }
            }
            DB::commit();

            return $appointment;

        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }
    }

    public function updateAppointment(StoreAndUpdateAppointmentApiRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());

            $appointment = Appointment::findOrFail($id);
            $services = $request->services;
            $all_services = $appointment->services;
            $patient = $request->get('patient');
            $employee = $request->get('employee');
            foreach ($all_services as $service) {
                $appointment->services()->detach($service->id);
            }
            $appointment->update([
                'title' => $request->get('title'),
                'starts_at' => Carbon::parse($request->get('starts_at')),
                'ends_at' => Carbon::parse($request->get('ends_at')),
                'employee_id' => $employee['id'],
                'patient_id' => $patient['id'],
                'color' => $employee['color'],
                'is_first_visit' => data_get($request, 'is_first_visit'),
                'status' => $request->get('status'),
                'price' => data_get($request, 'price'),
                'treatment_course_id' => data_get($request, 'treatment_course.id'),
            ]);

            foreach ($services as $service) {
                $appointment->services()->attach($service['service']['id'], ['amount'=>$service['quantity']]);
            }

            DB::commit();

            return $appointment;

        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }
    }

    public function deleteAppointment($id)
    {
        return Appointment::findOrFail($id)->delete();
    }

    public function getAppointmentsByEmployee(FilterAppointmentsApiRequest $request)
    {
        $time_from = $request->get('time_from', null);
        $time_to = $request->get('time_to', null);
        $employee_id = $request->get('employee_id', null);

        $query = Appointment::with(['employee', 'patient', 'treatmentCourse','services']);

        if (!!$time_from)
            $query = $query->whereDate('starts_at', '>=', Carbon::parse($time_from));

        if (!!$time_to)
            $query = $query->whereDate('ends_at', '<=', Carbon::parse($time_to));


        if (!!$employee_id)
            $query = $query->where('employee_id', $employee_id);

        return $query->get();

    }

    public function getPatientLastAppointments($patient_id, $currentUser)
    {
        if (!($currentUser->isEmployee() || $currentUser->isOwner())) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }

        $currentUser->load(['employee', 'employee.organization', 'employee.organization.patients']);
        if (!($currentUser->employee && $currentUser->employee->organization)) {
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'You are not allowed to do so'
                ],
                'errorCode' => ErrorCode::NOT_ALLOWED
            ]);
        }
        $query = Appointment::with(['employee', 'patient', 'treatmentCourse' , 'services'])
            ->where('patient_id',$patient_id)
            ->where('status',Appointment::STATUS_SUCCESS);

        $query = $query->whereHas('employee', function($query) use ($currentUser){
            $query->where('organization_id',$currentUser->employee->organization->id);
        });
        return $query->get();
    }

    public function updateAppointmentTime($id, $starts_at, $ends_at)
    {
        DB::beginTransaction();
        try{
            $appointment = Appointment::findOrFail($id);
            $appointment->update([
                'starts_at' => $starts_at,
                'ends_at' => $ends_at,
            ]);

            DB::commit();

            return $appointment;

        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }


    }
}