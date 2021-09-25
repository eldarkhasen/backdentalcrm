<?php


namespace App\Http\Resources\Treatment;


use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentTeethResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->tooth_number;

    }
}
