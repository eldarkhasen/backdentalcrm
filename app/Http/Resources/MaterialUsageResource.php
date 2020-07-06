<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialUsageResource extends JsonResource
{
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'materialRest' => $this->relationLoaded('materialRest')
                ? new MaterialRestResource($this->materialRest)
                : null,
            'employee' => $this->relationLoaded('employee')
                ? $this->employee
                : null,
            'created_at' => $this->created_at->isoFormat('DD.MM.YYYY HH:mm'),
        ]);
    }
}
