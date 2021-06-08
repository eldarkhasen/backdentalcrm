<?php


namespace App\Services\v1\impl;


use App\Models\Business\TreatmentTemplate;
use App\Services\v1\TreatmentTemplatesService;
use Illuminate\Http\Request;

class TreatmentTemplatesServiceImpl implements TreatmentTemplatesService
{
    public function store(Request $request){
        return TreatmentTemplate::updateOrCreate(['id' => $request->id],$request->all());
    }

}
