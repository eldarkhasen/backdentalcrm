<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialRestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'material' => $this->relationLoaded('material')
                ? new MaterialResource($this->material)
                : null,

            'organization' => $this->relationLoaded('organization')
                ? new OrganizationResource($this->organization)
                : null,

            'usages' => $this->relationLoaded('usages')
                ? new MaterialUsageResource($this->usages)
                : null,

            'deliveries' => $this->relationLoaded('deliveries')
                ? new MaterialDeliveryResource($this->deliveries)
                : null,
        ]);
    }
}
