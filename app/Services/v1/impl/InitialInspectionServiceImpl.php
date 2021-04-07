<?php


namespace App\Services\v1\impl;


use App\Exceptions\ApiServiceException;
use App\Http\Errors\ErrorCode;
use App\Http\Requests\Api\V1\Appointments\FilterAppointmentsApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreAndUpdateAppointmentApiRequest;
use App\Models\Business\Appointment;
use App\Models\Business\InitialInspection;
use App\Models\Business\InitInspectionType;
use App\Models\Business\InitInspectionTypeOption;
use App\Models\Business\Treatment;
use App\Models\Business\TreatmentCourse;
use App\Services\v1\AppointmentsService;
use App\Services\v1\BaseServiceImpl;
use App\Services\v1\InitialInspectionsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InitialInspectionServiceImpl
    extends BaseServiceImpl
    implements InitialInspectionsService
{


    public function getInitialInspectionTypes()
    {
        return InitInspectionType::with(['options' => function($q){
            $q->where('is_custom',false);
        }])->get();
    }

    public function store(Request $request){

        if($request->is_custom == true && !is_null($request->value)){
            $initInspectionType = InitInspectionTypeOption::updateOrCreate([
                'id'                        => $request->inspection_option_id,
                'init_inspection_type_id'   =>$request->inspection_type_id,
                'is_custom'                 => true,
            ],[
                'value' => $request->value
            ]);

            return InitialInspection::updateOrCreate([
                'appointment_id'        => $request->appointment_id,
                'inspection_type_id'    => $request->inspection_type_id
            ],[
                'inspection_option_id'  => $initInspectionType->id
            ]);

        } else {
            return InitialInspection::updateOrCreate([
                'appointment_id'        => $request->appointment_id,
                'inspection_type_id'    => $request->inspection_type_id
            ],[
                'inspection_option_id'  => $request->inspection_option_id
            ]);
        }
    }
}
