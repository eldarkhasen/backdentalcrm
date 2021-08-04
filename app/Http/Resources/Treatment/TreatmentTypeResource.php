<?php


namespace App\Http\Resources\Treatment;


use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'options' => $this->when(
                $this->relationLoaded('options'),
                TreatmentOptionResource::collection($this->options)
            ),
            'value' => $this->when(
                $this->relationLoaded('treatmentData'),
                data_get($this, 'treatmentData.value')
            ),
        ];
    }
}
