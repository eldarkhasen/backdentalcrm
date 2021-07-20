<?php


namespace App\Http\Resources\Treatment;


use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentOptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'is_custom' => $this->is_custom,
        ];
    }
}
