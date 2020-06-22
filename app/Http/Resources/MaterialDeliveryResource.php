<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialDeliveryResource extends JsonResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'material_rest' => $this->relationLoaded('materialRest')
                ? $this->materialRest
                : null,
        ]);
    }
}
