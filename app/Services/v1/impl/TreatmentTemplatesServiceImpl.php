<?php


namespace App\Services\v1\impl;


use App\Models\Business\TemplateOption;
use App\Models\Business\TreatmentOption;
use App\Models\Business\TreatmentTemplate;
use App\Models\Business\TreatmentType;
use App\Services\v1\TreatmentTemplatesService;
use Illuminate\Http\Request;

class TreatmentTemplatesServiceImpl implements TreatmentTemplatesService
{
    public function store(Request $request){
        return TreatmentTemplate::updateOrCreate(['id' => $request->id],$request->all());
    }

    public function storeType(Request $request){
        $type = TreatmentType::updateOrCreate([
            'id' => $request->id,
        ],[
            'name' => $request->name,
        ]);

        TemplateOption::updateOrCreate([
            'template_id' => $request->template_id,
            'type_id' => $type->id,
            'option_id' => null,
        ],[]);

        return $type;
    }

    public function storeOption(Request $request){
        $option = TreatmentOption::updateOrCreate([
            'id' => $request->id,
        ],[
            'value' => $request->value,
        ]);

        TemplateOption::updateOrCreate([
            'template_id' => $request->template_id,
            'type_id' => $request->type_id,
            'option_id' => $option->id,
        ],[]);

        return $option;
    }
}
