<?php


namespace App\Http\Resources\Treatment;


use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentTemplateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'types' => $this->when(
                $this->relationLoaded('types'),
                TreatmentTypeResource::collection($this->types)
            ),
        ];
    }
}
