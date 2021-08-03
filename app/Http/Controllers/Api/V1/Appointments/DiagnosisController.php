<?php


namespace App\Http\Controllers\Api\V1\Appointments;


use App\Http\Controllers\ApiBaseController;
use App\Models\Business\Diagnosis;

class DiagnosisController extends ApiBaseController
{
    public function index(){
        return $this->successResponse(
            Diagnosis::with('types')
                ->select('id', 'name', 'code', 'organization_id')
                ->get()
        );
    }
}
