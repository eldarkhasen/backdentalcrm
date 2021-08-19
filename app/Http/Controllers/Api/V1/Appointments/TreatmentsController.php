<?php


namespace App\Http\Controllers\Api\V1\Appointments;


use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\V1\Appointments\StoreTreatmentApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreTreatmentTemplateApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreTreatmentTypeApiRequest;
use App\Http\Requests\Api\V1\Appointments\StoreTreatmentTypeListApiRequest;
use App\Http\Requests\Api\V1\Appointments\TreatmentDataStoreListApiRequest;
use App\Http\Requests\Api\V1\Appointments\UpdateTreatmentDataListApiRequest;
use App\Http\Resources\Treatment\TreatmentTemplateCollection;
use App\Http\Resources\Treatment\TreatmentTemplateResource;
use App\Http\Resources\Treatment\TreatmentTypeResource;
use App\Models\Business\TemplateOption;
use App\Models\Business\Treatment;
use App\Models\Business\TreatmentData;
use App\Models\Business\TreatmentOption;
use App\Models\Business\TreatmentTemplate;
use App\Models\Business\TreatmentType;
use App\Services\v1\TreatmentService;
use App\Services\v1\TreatmentTemplatesService;
use Illuminate\Http\Request;

class TreatmentsController extends ApiBaseController
{
    private $treatmentService;
    private $treatmentTemplateService;

    public function __construct(TreatmentService $treatmentService, TreatmentTemplatesService $treatmentTemplateService)
    {
        $this->treatmentTemplateService = $treatmentTemplateService;
        $this->treatmentService = $treatmentService;
    }

    public function indexTemplates(){
        $templates = TreatmentTemplate::all();
        return $this->successResponse(TreatmentTemplateResource::collection($templates));
    }

    public function indexTemplatesPaginate(Request $request){
        $templates = TreatmentTemplate::when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search .'%')->orWhere('code', 'like', '%' . $request->search .'%');
        })->paginate($request->input('paginate', 10));

        return new TreatmentTemplateCollection($templates);
    }

    public function showTemplate($id){
        $template = TreatmentTemplate::with('types.options')->findOrFail($id);
        return $this->successResponse(TreatmentTypeResource::collection($template->types));
    }

    public function storeTemplate(StoreTreatmentTemplateApiRequest $request){
        $template = $this->treatmentTemplateService->store($request);
        return $this->successResponse(TreatmentTemplateResource::make($template));
    }

    public function storeType(StoreTreatmentTypeApiRequest $request){
        $type = $this->treatmentTemplateService->storeType($request);
        return $this->successResponse(TreatmentTypeResource::make($type));
    }

    public function storeTypeList(StoreTreatmentTypeListApiRequest $request){
        $types = $request->types;
        $type_ids = collect($types)->pluck('id');
        $option_ids = collect();
        foreach ($types as $type){
            $data = new Request([
                'id' => data_get($type, 'id'),
                'name' => data_get($type, 'name'),
                'template_id' => $request->template_id,
            ]);
            $new_type = $this->treatmentTemplateService->storeType($data);

            $type_ids->push($new_type->id);
            if(data_get($type, 'options')){
                foreach (data_get($type, 'options') as $option){
                    $data = new Request([
                        'id' => data_get($option, 'id'),
                        'value' => data_get($option, 'value'),
                        'template_id' => $request->template_id,
                        'type_id' => $new_type->id,
                    ]);
                    $new_option = $this->treatmentTemplateService->storeOption($data);
                    $option_ids->push($new_option->id);
                }
            }
        }
        $template_options = TemplateOption::where('template_id', $request->template_id)->get();
        TreatmentType::whereIn('id', $template_options->plucK('type_id'))->whereNotIn('id', $type_ids)->delete();
        TreatmentOption::whereIn('id', $template_options->pluck('option_id'))->whereNotIn('id', $option_ids)->delete();

        return $this->successResponse(['message' => 'Data updated successfully', 'type_ids' => $type_ids, 'option_ids' => $option_ids]);
    }

    public function deleteType($id){
        TreatmentType::findOrFail($id)->delete();
        return $this->successResponse(['message' => 'Type deleted successfully']);
    }

    public function deleteOption($id){
        TreatmentOption::findOrFail($id)->delete();
        return $this->successResponse(['message' => 'Option deleted successfully']);
    }

    public function deleteTemplate($id){
        TreatmentTemplate::findOrFail($id)->delete();
        return $this->successResponse(['message' => 'Template deleted successfully']);
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
        return $this->successResponse(['message' => 'Data stored successfully']);
    }

    public function updateTreatmentDataList(UpdateTreatmentDataListApiRequest $request){
        $treatment = $this->treatmentService->store($request);
        foreach ($request->types as $type){

            TreatmentData::updateOrCreate([
                'treatment_id' => $treatment->id,
                'template_id' => $request->template_id,
                'type_id'=> data_get($type, 'id'),
                'option_id' => null,
            ],[
                'value' => data_get($type, 'value'),
            ]);
            if(data_get($type, 'options')){
                foreach ($type['options'] as $option){
                    if(data_get($option, 'is_checked', false)){
                        TreatmentData::updateOrCreate([
                            'treatment_id' => $treatment->id,
                            'template_id' => $request->template_id,
                            'type_id'=> data_get($type, 'id'),
                            'option_id' => data_get($option, 'id'),
                        ],[

                        ]);
                    } else {
                        TreatmentData::where('treatment_id', $treatment->id)
                            ->where('template_id', $request->template_id)
                            ->where('type_id', data_get($type, 'id'))
                            ->where('option_id', data_get($option, 'id'))
                            ->delete();
                    }
                }
            }
        }

        return $this->successResponse(['message' => 'Data updated successfully ']);
    }
}
