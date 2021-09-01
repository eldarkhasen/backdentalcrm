<?php


namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAppointmentApiRequest;
use App\Http\Requests\Api\V1\Appointments\UpdateAppointmentApiRequest;
use App\Http\Resources\Treatment\TreatmentResource;
use App\Models\Business\Appointment;
use App\Models\Business\InitialInspection;
use App\Models\Business\InitInspectionType;
use App\Models\Business\Treatment;
use App\Models\Business\TreatmentCourse;
use App\Models\Business\TreatmentData;
use App\Models\Business\TreatmentTemplate;
use App\Models\CashFlow\CashBox;
use App\Models\CashFlow\CashFlowOperation;
use App\Models\CashFlow\CashFlowOperationType;
use App\Models\CashFlow\CashFlowType;
use App\Services\v1\AppointmentsService;
use App\Services\v1\BaseServiceImpl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use const App\Models\CashFlow\CASH_FLOW_TYPE_SERVICE;

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
        return Appointment::with([
            'employee',
            'patient',
            'treatmentCourse',
            'services',
            'initialInspection',
            'cashFlowOperation'
        ])
            ->findOrFail($id);

    }

    public function storeAppointment(StoreAppointmentApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->validateUserAccess($request->user());
            $main_cash_box = CashBox::where('is_main',true)->first();
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
                'is_first_visit' => data_get($request, 'is_first_visit'),
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
                    $appointment->services()->attach($serv['service']['id'], ['amount'=>$serv['quantity'],'actual_price'=>$serv['overallPrice'], 'discount'=>$serv['discount']]);
                }
            }
            DB::commit();

            return $appointment;

        } catch (\Exception $e) {
            $this->onError($e, 'System error', ErrorCode::SYSTEM_ERROR);
        }
    }

    public function updateAppointment(UpdateAppointmentApiRequest $request, $id)
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
            $status_color =  $employee['color'];
            if($request->get('status')=='success'){
                $status_color = "#808080";
            }else if($request->get('status')=='client_miss'){
                $status_color = "#FF0000";
            }
            $appointment->update([
                'starts_at' => Carbon::parse($request->get('starts_at')),
                'ends_at' => Carbon::parse($request->get('ends_at')),
                'employee_id' => $employee['id'],
                'patient_id' => $patient['id'],
                'color' => $status_color,
                'is_first_visit' => data_get($request, 'is_first_visit'),
                'status' => $request->get('status'),
                'price' => data_get($request, 'price'),
                'treatment_course_id' => data_get($request, 'treatment_course.id'),
            ]);

            foreach ($services as $service) {
                $appointment->services()->attach($service['service']['id'], ['amount'=>$service['quantity'],'actual_price'=>$service['overallPrice'], 'discount'=>$service['discount']]);
            }

            //Find in the cash flow operations this appointment
            $cashFlowOperation = CashFlowOperation::where('appointment_id',$appointment->id)->first();

            //if operation exists
            if($cashFlowOperation!=null){
                //Refresh Cashbox balance
                $cashBox = CashBox::find($cashFlowOperation->to_cash_box_id);
                $cashBox->balance = $cashBox->balance-$cashFlowOperation->amount;
                $cashBox->save();

                //Update Cashflow amount
                $cashFlowOperation->amount = $appointment->price;
                $cashFlowOperation->save();

                if($cashBox->id!=$request->get('cash_box_id')){
                    //Update cashbox ID in cashflow
                    $cashFlowOperation->to_cash_box_id=$request->get('cash_box_id');
                    $cashFlowOperation->save();

                    //Update to new cashbox
                    $cashBox = CashBox::find($request->get('cash_box_id'));
                }
                //Update cashbox balance
                $cashBox->balance = $cashBox->balance+$cashFlowOperation->amount;
                $cashBox->save();

            }else{
                //Create a new cash flow operation
                $newCashFlowOperation = CashFlowOperation::create([
                    'to_cash_box_id'=>$request->get('cash_box_id'),
                    'type_id'=>CashFlowOperationType::CASH_FLOW_TYPE_SERVICE,
                    'appointment_id'=>$appointment->id,
                    'amount'=>$appointment->price,
                    'user_created_id'=>$employee['id'],
                    'committed'=>1,
                    'cash_flow_date'=>Date::now()
                ]);

                $cashBox = CashBox::findOrFail($request->get('cash_box_id'));
                $cashBox->balance+=$newCashFlowOperation->amount;
                $cashBox->save();

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
        $query = Appointment::with(['employee', 'patient', 'services'])
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

    public function getAppointmentTreatments($id)
    {
        $treatments = Treatment::with([
//            'templates.types.options',
            'diagnosis',
            'diagnosisType',
        ])->where('appointment_id',$id)->get();

//        $treatments->load([
//            'templates.types.options.treatmentData' => function($q) use ($treatments) {
//                $q->whereIn('treatment_id', $treatments->pluck('id'));
//            },
//            'templates.types.treatmentData' => function($q) use ($treatments) {
//                $q->whereIn('treatment_id', $treatments->pluck('id'));
//            },
//        ]);

        return TreatmentResource::collection($treatments);
    }

    public function getAppointmentInitialInspections($id)
    {
//        return Appointment::with([
//            'initialInspectionTypes.options'  => function($q){
//                $q->where('is_custom', false)
//                    ->with(['initialInspections']);
//            },
//            'initialInspectionTypes.customOptions'=> function($q){
//                $q->when('is_custom', function ($qq){
//                    $qq->with(['initialInspections'])
//                        ->has('initialInspections');
//                });
//            },
//            ])
//            ->findOrFail($id);
        // version 3
        return InitInspectionType::with([
            'options'  => function($q)use($id){
                $q->where('is_custom', false)
                    ->with([
                        'initialInspections' => function($qq)use($id){
                            $qq->where('appointment_id', $id);
                        }
                    ]);
            },
            'customOptions'=> function($q)use($id){
                $q->when('is_custom', function ($qq)use($id){
                    $qq->whereHas('initialInspections',  function($qqq)use($id) {
                        $qqq->where('appointment_id', $id);
                    });
                });
            },
            ])
            ->get();
        //version 2
//        return InitialInspection::where('appointment_id',$id)->with(['inspectionType','inspectionTypeOption','appointment'])->get();
    }
}
