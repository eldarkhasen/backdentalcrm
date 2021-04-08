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
        if($request->is_checked == true){
            if($request->is_custom == true && !is_null($request->value)){
                $initInspectionType = InitInspectionTypeOption::updateOrCreate([
                    'id' => $request->custom_id,
                ],[
                    'init_inspection_type_id'   =>$request->inspection_type_id,
                    'is_custom'                 => true,
                    'value' => $request->value
                ]);

                return InitialInspection::updateOrCreate([
                    'appointment_id'        => $request->appointment_id,
                    'inspection_type_id'    => $request->inspection_type_id,
                    'inspection_option_id'  => $initInspectionType->id
                ],[]);

            } else {

                return InitialInspection::updateOrCreate([
                    'appointment_id'        => $request->appointment_id,
                    'inspection_type_id'    => $request->inspection_type_id,
                    'inspection_option_id'  => $request->inspection_option_id
                ], []);

            }
        } elseif ($request->is_checked == false){
            return InitialInspection::where('appointment_id',$request->appointment_id)
                ->where('inspection_option_id', $request->inspection_option_id)
                ->delete();
        }
    }

    public function delete($id){
        return InitialInspection::with(['inspectionTypeOption'])->findOrFail($id);
    }

    public function bigStore(Request $request){
        $inspection_type_ids = $request->options;
        $custom_type_ids = $request->customs;

        $option_ids = [];
        $input = new Request();
        $input['appointment_id'] = $request->appointment_id;

        foreach ($inspection_type_ids as $inspection_type_id => $inspection_option_ids){
            $input['inspection_type_id'] = $inspection_type_id;
            foreach ($inspection_option_ids as $inspection_option_id ){
                $input['inspection_option_id'] = $inspection_option_id;
                $this->create($input);

                array_push($option_ids, $inspection_option_id);
            }
        }

        foreach ($custom_type_ids as $inspection_type_id => $value){
            $input['inspection_type_id'] = $inspection_type_id;
            $input['value'] = $value;
            $input['is_custom'] = true;
            $inspection_option_id = $this->create($input)->inspection_option_id;

            array_push($option_ids, $inspection_option_id);
        }

        InitialInspection::where('appointment_id', $request->appointment_id)
            ->whereNotIn('inspection_option_id', $option_ids)
            ->delete();
        $inspections = InitialInspection::where('appointment_id', $request->appointment_id)->get();

        return $inspections;
    }
}
