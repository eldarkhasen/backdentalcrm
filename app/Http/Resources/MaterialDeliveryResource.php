<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialDeliveryResource extends JsonResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'materialRest' => $this->relationLoaded('materialRest')
                ? $this->materialRest
                : null,
            'delivery_date' => $this->delivery_date->isoFormat('DD.MM.YYYY HH:mm'),
        ]);
    }
}
