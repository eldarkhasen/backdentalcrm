<?php


namespace App\Http\Controllers\Api\V1\Appointments;


use App\Http\Controllers\ApiBaseController;
use App\Http\Resources\Treatment\TreatmentTemplateResource;
use App\Http\Resources\Treatment\TreatmentTypeResource;
use App\Models\Business\TreatmentTemplate;
use App\Models\Business\TreatmentType;

class TreatmentsController extends ApiBaseController
{
    public function indexTemplates(){
        $templates = TreatmentTemplate::all();
        return $this->successResponse(TreatmentTemplateResource::collection($templates));
    }

    public function showTemplate($id){
        $template = TreatmentTemplate::with('types.options')->findOrFail($id);
        return $this->successResponse(TreatmentTypeResource::collection($template->types));
    }
}
