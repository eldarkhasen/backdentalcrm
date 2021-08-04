<?php


namespace App\Http\Controllers\Api\V1\Appointments;


use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Appointments\StoreTreatmentApiRequest;
use App\Http\Requests\Api\V1\Appointments\TreatmentDataStoreListApiRequest;
use App\Http\Resources\Treatment\TreatmentTemplateResource;
use App\Http\Resources\Treatment\TreatmentTypeResource;
use App\Models\Business\Treatment;
use App\Models\Business\TreatmentData;
use App\Models\Business\TreatmentTemplate;
use App\Models\Business\TreatmentType;
use App\Services\v1\TreatmentService;
use Illuminate\Http\Request;

class TreatmentsController extends ApiBaseController
{
    private $treatmentService;

    public function __construct(TreatmentService $treatmentService)
    {
        $this->treatmentService = $treatmentService;
    }

    public function indexTemplates(){
        $templates = TreatmentTemplate::all();
        return $this->successResponse(TreatmentTemplateResource::collection($templates));
    }

    public function showTemplate($id){
        $template = TreatmentTemplate::with('types.options')->findOrFail($id);
        return $this->successResponse(TreatmentTypeResource::collection($template->types));
    }

    public function store(StoreTreatmentApiRequest $request){
        return $this->successResponse(
            $this->treatmentService->store($request)
        );
    }

    public function storeTreatmentDataList(TreatmentDataStoreListApiRequest $request){
        $treatment = $this->treatmentService->store($request);

        foreach ($request->data as $data){
            if(data_get($data, 'is_checked', false)){
                TreatmentData::updateOrCreate([
                    'treatment_id' => $treatment->id,
                    'template_id' => $request->template_id,
                    'type_id'=> data_get($data, 'type_id'),
                    'option_id' => data_get($data, 'option_id'),
                ],[
                    'value' => data_get($data, 'value'),
                ]);
            } else {
                TreatmentData::where('treatment_id', $request->treatment_id)
                    ->where('template_id', $request->template_id)
                    ->where('type_id', data_get($data, 'type_id'))
                    ->where(function ($q) use ($data) {
                        $q->where('option_id', data_get($data, 'option_id'))
                            ->orWhere('value', data_get($data, 'value'));
                    })
                    ->delete();
            }

        }
        return $this->successResponse(['message' => 'Data successfully stored']);
    }
}
