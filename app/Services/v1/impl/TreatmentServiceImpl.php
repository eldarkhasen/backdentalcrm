<?php


namespace App\Services\v1\impl;


use App\Models\Business\Treatment;
use App\Services\v1\TreatmentService;
use Illuminate\Http\Request;

class TreatmentServiceImpl implements TreatmentService
{
    public function store(Request $request){
        return Treatment::updateOrCreate(['id' => $request->id,], $request->toArray());
    }
}
