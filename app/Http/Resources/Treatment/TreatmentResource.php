<?php


namespace App\Http\Resources\Treatment;


use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'appointment_id' => $this->appointment_id,
            'diagnosis_id' => $this->diagnosis_id,
            'diagnosis' => $this->when(
                $this->relationLoaded('diagnosis'),
                ($this->diagnosis)
            ),
            'diagnosis_type_id' => $this->diagnosis_type_id,
            'diagnosis_type' => $this->when(
                $this->relationLoaded('diagnosisType'),
                ($this->diagnosisType)
            ),
            'tooth_number'=> $this->tooth_number,
            'is_finished' => $this->is_finished,
            'final_diagnosis_id'=>$this->final_diagnosis_id,
            'created_at' => $this->created_at,
            'templates' => $this->when(
                $this->relationLoaded('templates'),
                TreatmentTemplateResource::collection($this->templates)
            ),
        ];
    }
}
