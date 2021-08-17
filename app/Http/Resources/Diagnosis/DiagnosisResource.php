<?php


namespace App\Http\Resources\Diagnosis;


use Illuminate\Http\Resources\Json\JsonResource;

class DiagnosisResource extends JsonResource
{
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'organization_id' => $this->organization_id
        ];
    }
}
