<?php


namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAndUpdateAppointmentApiRequest;
use App\Models\Business\Appointment;
use App\Models\Business\TreatmentCourse;
use App\Services\v1\AppointmentsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentsServiceImpl implements AppointmentsService
{

    public function getAppointments(FilterAppointmentsApiRequest $request)
    {
        $time_from = $request->get('time_from', null);
        $time_to = $request->get('time_to', null);

        $employee_ids = $request->get('employee_ids', null);
        $patient_ids = $request->get('patient_ids', null);

        $search_key = $request->get('search_key', null);

        $query = Appointment::with(['employee', 'patient', 'treatmentCourse']);

        if (!!$time_from)
            $query = $query->whereDate('starts_at', '>=', Carbon::parse($time_from));

        if (!!$time_to)
            $query = $query->whereDate('ends_at', '<=', Carbon::parse($time_to));

        if (!!$employee_ids and count($employee_ids) > 0)
            $query = $query->whereIn('employee_id', $employee_ids);

        if (!!$patient_ids and count($patient_ids) > 0)
            $query = $query->whereIn('patient_id', $patient_ids);

        if (!!$search_key and $search_key != '')
            $query = $query->where('title', 'like', '%' . $search_key . '%');

        return $query->get();
    }

    public function getAppointmentById($id)
    {
        return Appointment::with(['employee', 'patient', 'treatmentCourse'])->findOrfail($id);
    }

    public function storeAppointment(StoreAndUpdateAppointmentApiRequest $request)
    {
        DB::beginTransaction();
        try {
            if (!($request->user()->isEmployee() || $request->user()->isOwner())) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'You are not allowed to do so'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            $appointment = new Appointment();
            $appointment->fill([
                'starts_at'   => Carbon::parse($request->get('starts_at')),
                'ends_at'     => Carbon::parse($request->get('ends_at')),
                'employee_id' => data_get($request, 'employee.id'),
                'patient_id'  =>  data_get($request,'patient.id'),
                'color'       => data_get($request, 'employee.color'),
                'is_first_visit' =>  data_get($request,'is_first_visit')
            ]);

            $patient = $request->get('patient');
            $appointment->title = $patient['surname'] . " " .
                $patient['name'] . " " . $patient['patronymic'] . ", " . $patient['phone'];

            $course_id = !!$request->treatment_course['id']
                ? $request->treatment_course['id']
                : TreatmentCourse::create(['name' => $appointment->title])->id;

            $appointment->treatment_course_id = $course_id;

            $appointment->save();
            DB::commit();
            return $appointment;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'System error',
                    $e->getMessage()
                ],
                'errorCode' => ErrorCode::SYSTEM_ERROR
            ]);
        }
    }

    public function updateAppointment(StoreAndUpdateAppointmentApiRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if (!($request->user()->isEmployee() || $request->user()->isOwner())) {
                throw new ApiServiceException(400, false, [
                    'errors' => [
                        'You are not allowed to do so'
                    ],
                    'errorCode' => ErrorCode::NOT_ALLOWED
                ]);
            }

            $appointment = Appointment::findOrFail($id);

            $appointment->update([
                'title'          => $request->get('title'),
                'starts_at'      => Carbon::parse($request->get('starts_at')),
                'ends_at'        => Carbon::parse($request->get('ends_at')),
                'employee_id'    => data_get($request, 'employee.id'),
                'patient_id'     => data_get($request,'patient.id'),
                'color'          => data_get($request, 'employee.color'),
                'is_first_visit' => data_get($request,'is_first_visit'),
                'status'         => $request->get('status'),
                'treatment_course_id' => data_get($request,'treatment_course.id'),
            ]);

            DB::commit();

            return $appointment;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiServiceException(400, false, [
                'errors' => [
                    'System error',
                    $e->getMessage()
                ],
                'errorCode' => ErrorCode::SYSTEM_ERROR
            ]);
        }
    }

    public function deleteAppointment($id)
    {
        return Appointment::findOrFail($id)->delete();
    }
}